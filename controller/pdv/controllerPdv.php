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
    try {
        $id_venda = cadastrar_venda(); // cadastra venda e retorna id

        venda_itens($id_venda);        // cadastra itens relacionados

        insert_metodo_pag($id_venda);

        
        echo "
        <script>
        alert('Venda realizada com sucesso.');
        window.location.href = '../../view/pdv.php';
        </script>";
        limpar_venda(false);

    } catch (Exception $e) {
        echo "
        <script>
        alert('Erro ao registrar venda. Detalhes: " . addslashes($e->getMessage()) . "');
        window.location.href = '../../view/pdv.php';
        </script>";
        limpar_venda(false);
    }
}

function cadastrar_venda(): int
{
    global $con;

    $id_usuario = $_SESSION["id_usuario"];
    $data_hora = new DateTime();
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
        return; // sem itens para cadastrar
    }

    foreach ($itens as $item) {
        $venda_itens = new VendaItens(
            0,
            $id_venda,
            $item["id_item"],
            $item["quantidade"]
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