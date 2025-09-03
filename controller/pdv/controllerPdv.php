<?php
require_once __DIR__ . "/../../model/itens/classItens.php";
require_once __DIR__ . "/../../model/vendas/vendas.php";
require_once __DIR__ . "/../../model/vendas/vendas_itens.php";
require_once __DIR__ . "/../../model/vendas/metodo_pag.php";
require_once __DIR__ . "/../../conexao.php";

session_start();

removerItem();
recalcular_total();
// adicionar_item(); // ← ESSENCIAL
function adicionar_item()
{
    // Se recebeu um novo item via POST, adiciona à lista da sessão
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item'])) {
        $novoItem = trim($_POST['item']);
        $quantidade = intval($_POST['quantidade'] ?? 1); // pega quantidade (padrão 1)

        if ($novoItem !== '') {
            $item = procurarItem($_POST['item']);
            if ($item) {
                // adiciona a quantidade junto
                $item['quantidade'] = $quantidade;
                $_SESSION['itens'][] = $item;
            }
        }
    }
    $ultimoItem = end($_SESSION['itens']);
    atualizar_total($ultimoItem['val_unitario'], $_POST['quantidade']);

    header("Location: ../../view/pdv.php");
}
function procurarItem($id)
{
    global $con;
    $sql = "SELECT * FROM itens WHERE id_item = :id_item";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id_item', $id);
    $stmt->execute();
    return $stmt->fetch();
}
function removerItem()
{
    if (isset($_GET['remover'])) {
        $index = intval($_GET['remover']);
        if (isset($_SESSION['itens'][$index])) {
            unset($_SESSION['itens'][$index]); // remove do array
            $_SESSION['itens'] = array_values($_SESSION['itens']); // reorganiza os índices
        }
        header("Location: ../../view/pdv.php");
        exit;
    }
}

function recalcular_total()
{
    $total = 0.0;
    if (isset($_SESSION['itens'])) {
        foreach ($_SESSION['itens'] as $item) {
            $total += $item['val_unitario'] * $item['quantidade'];
        }
    }
    $_SESSION['total'] = $total;
}

function atualizar_total($val_uni, $quant): void
{
    $total = (float) $_SESSION['total'];
    $subtotal = $val_uni * $quant;
    $total += $subtotal;
    $_SESSION['total'] = $total;
}


function processa_metodos(): void
{
    // Detectar método
    $metodo = $_POST['metodo'] ?? null;

    if ($metodo) {
        $pagamento = ['metodo' => $metodo];

        // Dependendo do método, pegar valor e dados específicos
        if ($metodo === 'dinheiro') {
            $pagamento['valor'] = floatval($_POST['dinheiro'] ?? 0);
        } elseif ($metodo === 'cartao-debito') {
            $pagamento['valor'] = floatval($_POST['cartao'] ?? 0);
            $pagamento['cartao'] = $_POST['cartao_debito'] ?? '';
        } elseif ($metodo === 'cartao-credito') {
            $pagamento['valor'] = floatval($_POST['cartao'] ?? 0);
            $pagamento['cartao'] = $_POST['cartao_credito'] ?? '';
        }

        // Adicionar no array da sessão
        $_SESSION['metodos_pagamento'][] = $pagamento;

        atualizar_subtotal($pagamento['valor']);

        //redirecionar para evitar reenvio de formulário
        header("Location: ../../view/pdv.php?finalizar=1");
        exit;
    }

}

function atualizar_subtotal($valor)
{
    $subtotal = (float) ($_SESSION['subtotal'] ?? $_SESSION['total']);
    $subtotal -= $valor;

    $_SESSION['subtotal'] = max($subtotal, 0); // Evita subtotal negativo

    // Se pagou mais que o total, calcula troco
    $totalPago = 0.0;
    foreach ($_SESSION['metodos_pagamento'] as $p) {
        $totalPago += $p['valor'];
    }

    $totalCompra = $_SESSION['total'];
    $_SESSION['troco'] = $totalPago > $totalCompra ? $totalPago - $totalCompra : 0.0;
}


function finalizar_compra(): void
{
    global $con;

    try {
        // Verifica se existe método de pagamento selecionado
        verificar_metodo_pagamento();

        // Inicia transação para garantir atomicidade
        $con->beginTransaction();

        // Verificar estoque para todos os itens antes de cadastrar a venda
        verificar_estoque_itens();

        // Cadastra venda e pega o ID
        $id_venda = cadastrar_venda();

        // Cadastra itens relacionados
        venda_itens($id_venda);

        // Cadastra métodos de pagamento
        insert_metodo_pag($id_venda);

        // Confirma a transação
        $con->commit();

        echo "
        <script>
        alert('Venda realizada com sucesso.');
        window.location.href = '../../view/pdv.php';
        </script>";
        limpar_venda(false);

    } catch (Exception $e) {
        // Desfaz a transação caso algo falhe
        if ($con->inTransaction()) {
            $con->rollBack();
        }

        echo "
        <script>
        alert('Erro ao registrar venda. Detalhes: " . addslashes($e->getMessage()) . "');
        window.location.href = '../../view/pdv.php';
        </script>";
        limpar_venda(false);
    }
}

function verificar_estoque_itens(): void
{
    global $con;

    $itens = $_SESSION["itens"] ?? [];

    foreach ($itens as $item) {
        $id_item = $item["id_item"];
        $quantidade_vendida = $item["quantidade"];

        $stmt_check = $con->prepare("SELECT quant FROM itens WHERE id_item = :id_item");
        $stmt_check->bindValue(":id_item", $id_item, PDO::PARAM_INT);
        $stmt_check->execute();
        $estoque_atual = $stmt_check->fetchColumn();

        if ($estoque_atual === false) {
            throw new Exception("Item ID $id_item não encontrado no estoque.");
        }

        if ($estoque_atual < $quantidade_vendida) {
            throw new Exception("Estoque insuficiente para o item ID: $id_item. Estoque atual: $estoque_atual, quantidade solicitada: $quantidade_vendida.");
        }
    }
}

function verificar_metodo_pagamento(): void
{
    $metodos_pagamento = $_SESSION["metodos_pagamento"] ?? [];

    if (empty($metodos_pagamento)) {
        throw new Exception("Nenhum método de pagamento selecionado.");
    }

    // Opcional: pode também validar se os valores são válidos e > 0
    $valor_total_pago = 0;
    foreach ($metodos_pagamento as $metodo) {
        if (!isset($metodo["valor"]) || $metodo["valor"] <= 0) {
            throw new Exception("Valor inválido no método de pagamento.");
        }
        $valor_total_pago += $metodo["valor"];
    }

    if ($valor_total_pago <= 0) {
        throw new Exception("Nenhum valor válido foi informado para os métodos de pagamento.");
    }
}


function cadastrar_venda(): int
{
    global $con;

    $id_usuario = $_SESSION["id_usuario"];
    $data_hora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $valor_total = $_SESSION["total"];

    $venda = new Vendas(
        0,
        $id_usuario,
        NULL,
        $data_hora,
        $valor_total
    );

    $sql = "INSERT INTO `vendas`(`id_usuario`, `id_comanda`, `valor_total`, `data_hora`) 
            VALUES (:id_usuario, :id_comanda, :valor_total, :data_hora)";
    $stmt = $con->prepare($sql);

    $stmt->bindValue(":id_usuario", $venda->getIdUsuario(), PDO::PARAM_INT);

    $id_comanda = $venda->getIdComanda();
    if ($id_comanda === null) {
        $stmt->bindValue(":id_comanda", null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(":id_comanda", $id_comanda, PDO::PARAM_INT);
    }

    $stmt->bindValue(":valor_total", $venda->getValorTotal(), PDO::PARAM_INT);
    $stmt->bindValue(":data_hora", $venda->getDataHora()->format('Y-m-d H:i:s'), PDO::PARAM_STR);

    if (!$stmt->execute()) {
        throw new Exception("Falha ao inserir venda.");
    }

    return (int) $con->lastInsertId();
}

function venda_itens(int $id_venda): void
{
    global $con;

    $itens = $_SESSION["itens"] ?? [];

    if (empty($itens)) {
        return;
    }

    foreach ($itens as $item) {
        $id_item = $item["id_item"];
        $quantidade_vendida = $item["quantidade"];

        // Inserir o item na venda
        $venda_itens = new VendaItens(
            0,
            $id_venda,
            $id_item,
            $quantidade_vendida
        );

        $sql = "INSERT INTO `vendas_itens`(`id_venda`, `id_item`, `quantidade`) 
                VALUES (:id_venda, :id_item, :quantidade)";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id_venda", $venda_itens->getIdVenda(), PDO::PARAM_INT);
        $stmt->bindValue(":id_item", $venda_itens->getIdItem(), PDO::PARAM_INT);
        $stmt->bindValue(":quantidade", $venda_itens->getQuantidade(), PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Falha ao inserir item da venda.");
        }

        // Atualizar o estoque
        $sql_update = "UPDATE `itens` 
                       SET `quant` = `quant` - :quantidade 
                       WHERE `id_item` = :id_item";

        $stmt_update = $con->prepare($sql_update);
        $stmt_update->bindValue(":quantidade", $venda_itens->getQuantidade(), PDO::PARAM_INT);
        $stmt_update->bindValue(":id_item", $venda_itens->getIdItem(), PDO::PARAM_INT);

        if (!$stmt_update->execute()) {
            throw new Exception("Falha ao atualizar o estoque do item ID: {$venda_itens->getIdItem()}");
        }
    }
}


function insert_metodo_pag(int $id_venda) {
    global $con;

    $metodos_pagamento = $_SESSION["metodos_pagamento"] ?? [];

    if (empty($metodos_pagamento)) {
        return; // sem nada para cadastrar
    }

    foreach ($metodos_pagamento as $metodo) {
        if (!empty($p["cartao"])):
            $metodo["metodo"] .= ["cartao"];
        endif;
        $class_metPag = new MetodoPagamento(
            0,
            $id_venda,
            $metodo["metodo"],
            $metodo["valor"]
        );

        $sql = "INSERT INTO `metodos_pag`(`id_venda`, `metodo`, `valor_pago`) 
                VALUES (:id_venda, :metodo, :valor_pago)";

        $stmt = $con->prepare($sql);

        $stmt->bindValue(":id_venda", $class_metPag->getIdVenda(), PDO::PARAM_INT);
        $stmt->bindValue(":metodo", $class_metPag->getMetodo(), PDO::PARAM_STR);
        $stmt->bindValue(":valor_pago", $class_metPag->getValorPago(), PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception("Falha ao inserir método de pagamento da venda.");
        }
    }
}

function limpar_venda($redirecionar)
{
    unset($_SESSION["itens"]);
    unset($_SESSION["total"]);
    unset($_SESSION["subtotal"]);
    unset($_SESSION["troco"]);
    unset($_SESSION["metodos_pagamento"]);
    if ($redirecionar) {
        header("Location: ../../view/pdv.php");
    }
    exit;
}