<?php
// Inclui as classes e arquivos necessários para manipulação de itens, vendas e conexão com o banco
require_once __DIR__ . "/../../model/itens/classItens.php";
require_once __DIR__ . "/../../model/vendas/vendas.php";
require_once __DIR__ . "/../../model/vendas/vendas_itens.php";
require_once __DIR__ . "/../../model/vendas/metodo_pag.php";
require_once __DIR__ . "/../../conexao.php";

// Inicia a sessão caso ainda não tenha sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Recalcula o total da venda ao carregar o controlador
recalcular_total();

removerItem();
editarItem();
// Funções principais do PDV (adicionar, remover e editar itens)
// adicionar_item(); // ← ESSENCIAL (descomentando, ativa a função de adicionar item)

/**
 * Adiciona um item ao carrinho (sessão)
 */
function adicionar_item()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["item"])) {
        $valor = trim($_POST["item"]);
        $idItem = null;
        $novoItem = null;

        // Verifica se começa com C/c + números
        if (preg_match('/^[cC](\d+)$/', $valor, $matches)) {
            $codigo_comanda = $matches[1]; // Pega só os números
            // Procura uma comanda com o ID
            adicionar_comanda($codigo_comanda);

            // Já sai da função, pra não rodar o resto
            return;
        }

        // Se for apenas número puro -> ID
        if (is_numeric($valor)) {
            $idItem = $valor;
        } else {
            $novoItem = $valor; // Senão, trata como nome
        }

        if ($_POST["quantidade"] === "") {
            echo "
            <script>
                alert('Para adicionar um item, é necessário informar sua quantidade.');
                window.location.href='../../view/pdv.php';
            </script>";
            exit();
        }

        // Pega a quantidade informada (padrão 1)
        $quantidade = floatval($_POST["quantidade"] ?? 1);

        // Procura o item no banco e adiciona ao carrinho se encontrado
        if ($novoItem !== "" || $idItem !== null) {
            $item = procurarItem($idItem, $novoItem);
            if ($item) {
                $item["quantidade"] = $quantidade;
                $_SESSION["itens"][] = $item;
            }
        }

        // Atualiza o total da venda
        $ultimoItem = end($_SESSION["itens"]);
        atualizar_total($ultimoItem["val_unitario"], $quantidade);

        // Limpa dados de edição e redireciona para a tela do PDV
        unset($_SESSION["editar"]);
        header("Location: ../../view/pdv.php");
    }
}

/**
 * Procura um item no banco de dados pelo ID ou nome
 */
function procurarItem($id = null, $nome_item = null)
{
    global $con;
    $sql = "SELECT * FROM itens WHERE 1=1";
    if ($id !== null && $id !== "") {
        $sql .= " AND id_item = :id_item";
    }
    if ($nome_item !== null && $nome_item !== "") {
        $sql .= " AND nome_item = :nome_item";
    }
    $stmt = $con->prepare($sql);
    if ($id !== null && $id !== "") {
        $stmt->bindParam(":id_item", $id, PDO::PARAM_INT);
    }
    if ($nome_item !== null && $nome_item !== "") {
        $stmt->bindParam(":nome_item", $nome_item, PDO::PARAM_STR);
    }
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Remove um item do carrinho (sessão) pelo índice
 */
function removerItem()
{
    if (isset($_GET["remover"])) {
        $index = intval($_GET["remover"]);
        if (isset($_SESSION["itens"][$index])) {
            unset($_SESSION["itens"][$index]); // remove do array
            $_SESSION["itens"] = array_values(array: $_SESSION["itens"]); // reorganiza os índices
        }
        header("Location: ../../view/pdv.php");
        exit();
    }
}

/**
 * Edita um item do carrinho, removendo-o e salvando seus dados para edição
 */
function editarItem()
{
    if (isset($_GET["editar"])) {
        $index = intval($_GET["editar"]);

        if (isset($_SESSION["itens"][$index])) {
            // pega o item selecionado
            $itemSelecionado = $_SESSION["itens"][$index];

            // remove da lista
            unset($_SESSION["itens"][$index]);
            $_SESSION["itens"] = array_values($_SESSION["itens"]);

            // guarda info para reaproveitar no formulário
            $_SESSION["editar"] = [
                "nome" => $itemSelecionado["nome_item"],
                "quantidade" => $itemSelecionado["quantidade"],
            ];
        }
        header("Location: ../../view/pdv.php");
        exit();
    }
}

/**
 * Recalcula o total da venda somando todos os itens do carrinho
 */
function recalcular_total()
{
    $total = 0.0;
    if (isset($_SESSION["itens"])) {
        foreach ($_SESSION["itens"] as $item) {
            $total += $item["val_unitario"] * $item["quantidade"];
        }
    }
    $_SESSION["total"] = $total;
}

/**
 * Atualiza o total da venda ao adicionar um novo item
 */
function atualizar_total($val_uni, $quant): void
{
    $total = (float) $_SESSION["total"];
    $subtotal = $val_uni * $quant;
    $total += $subtotal;
    $_SESSION["total"] = $total;
}

/**
 * Processa o método de pagamento selecionado e atualiza o subtotal/troco
 */
function processa_metodos(): void
{
    // Detecta o método de pagamento enviado pelo formulário
    $metodo = $_POST["metodo"] ?? null;

    if ($metodo) {
        $pagamento = ["metodo" => $metodo];

        // Dependendo do método, pega valor e dados específicos
        if ($metodo === "dinheiro") {
            $pagamento["valor"] = floatval($_POST["dinheiro"] ?? 0);
        } elseif ($metodo === "cartao-debito") {
            $pagamento["valor"] = floatval($_POST["cartao"] ?? 0);
            $pagamento["cartao"] = $_POST["cartao_debito"] ?? "";
        } elseif ($metodo === "cartao-credito") {
            $pagamento["valor"] = floatval($_POST["cartao"] ?? 0);
            $pagamento["cartao"] = $_POST["cartao_credito"] ?? "";
        }

        // Adiciona o método de pagamento na sessão
        $_SESSION["metodos_pagamento"][] = $pagamento;

        // Atualiza o subtotal (valor restante a pagar)
        atualizar_subtotal($pagamento["valor"]);

        // Redireciona para evitar reenvio do formulário
        header("Location: ../../view/pdv.php?finalizar=1");
        exit();
    }
}

/**
 * Atualiza o subtotal (valor restante a pagar) e calcula o troco, se houver
 */
function atualizar_subtotal($valor)
{
    $subtotal = (float) ($_SESSION["subtotal"] ?? $_SESSION["total"]);
    $subtotal -= $valor;

    $_SESSION["subtotal"] = max($subtotal, 0); // Evita subtotal negativo

    // Se pagou mais que o total, calcula troco
    $totalPago = 0.0;
    foreach ($_SESSION["metodos_pagamento"] as $p) {
        $totalPago += $p["valor"];
    }

    $totalCompra = $_SESSION["total"];
    $_SESSION["troco"] =
        $totalPago > $totalCompra ? $totalPago - $totalCompra : 0.0;
}

/**
 * Finaliza a compra, cadastrando a venda, itens e métodos de pagamento no banco
 */
function finalizar_compra(): void
{
    global $con;

    try {
        // Verifica se existe método de pagamento selecionado
        verificar_metodo_pagamento();

        // Inicia transação para garantir atomicidade
        $con->beginTransaction();

        // Verifica o estoque de todos os itens antes de cadastrar a venda
        verificar_estoque_itens();

        // Cadastra venda e pega o ID
        $id_venda = cadastrar_venda();

        // Cadastra itens relacionados à venda
        venda_itens($id_venda);

        // Cadastra métodos de pagamento utilizados
        insert_metodo_pag($id_venda);

        // Fechar qualquer comanda aberta
        if (!empty($_SESSION["comanda"])) {
            fechar_comanda($_SESSION["comanda"]);
        }

        // Confirma a transação
        $con->commit();

        // Exibe mensagem de sucesso e limpa a venda
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

        // Exibe mensagem de erro e limpa a venda
        echo "
        <script>
        alert('Erro ao registrar venda. Detalhes: " .
            addslashes($e->getMessage()) .
            "');
        window.location.href = '../../view/pdv.php';
        </script>";
        limpar_venda(false);
    }
}

/**
 * Verifica se há estoque suficiente para todos os itens da venda
 */
function verificar_estoque_itens(): void
{
    global $con;

    $itens = $_SESSION["itens"] ?? [];

    foreach ($itens as $item) {
        $id_item = $item["id_item"];
        $quantidade_vendida = $item["quantidade"];

        $stmt_check = $con->prepare(
            "SELECT quant FROM itens WHERE id_item = :id_item",
        );
        $stmt_check->bindValue(":id_item", $id_item, PDO::PARAM_INT);
        $stmt_check->execute();
        $estoque_atual = $stmt_check->fetchColumn();

        if ($estoque_atual === false) {
            throw new Exception("Item ID $id_item não encontrado no estoque.");
        }

        if ($estoque_atual < $quantidade_vendida) {
            throw new Exception(
                "Estoque insuficiente para o item ID: $id_item. Estoque atual: $estoque_atual, quantidade solicitada: $quantidade_vendida.",
            );
        }
    }
}

/**
 * Verifica se pelo menos um método de pagamento foi selecionado e se os valores são válidos
 */
function verificar_metodo_pagamento(): void
{
    $metodos_pagamento = $_SESSION["metodos_pagamento"] ?? [];

    if (empty($metodos_pagamento)) {
        throw new Exception("Nenhum método de pagamento selecionado.");
    }

    // Valida se os valores dos métodos são válidos e maiores que zero
    $valor_total_pago = 0;
    foreach ($metodos_pagamento as $metodo) {
        if (!isset($metodo["valor"]) || $metodo["valor"] <= 0) {
            throw new Exception("Valor inválido no método de pagamento.");
        }
        $valor_total_pago += $metodo["valor"];
    }

    if ($valor_total_pago <= 0) {
        throw new Exception(
            "Nenhum valor válido foi informado para os métodos de pagamento.",
        );
    }
}

/**
 * Cadastra a venda no banco de dados e retorna o ID gerado
 */
function cadastrar_venda(): int
{
    global $con;

    $id_usuario = $_SESSION["id_usuario"];
    $data_hora = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
    $valor_total = $_SESSION["total"];
    $id_comanda = !empty($_SESSION["comanda"]) ? $_SESSION["comanda"] : null;

    $venda = new Vendas(0, $id_usuario, $id_comanda, $data_hora, $valor_total);

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

    $stmt->bindValue(":valor_total", $venda->getValorTotal(), PDO::PARAM_STR);
    $stmt->bindValue(
        ":data_hora",
        $venda->getDataHora()->format("Y-m-d H:i:s"),
        PDO::PARAM_STR,
    );

    if (!$stmt->execute()) {
        throw new Exception("Falha ao inserir venda.");
    }

    return (int) $con->lastInsertId();
}

/**
 * Cadastra os itens vendidos na tabela vendas_itens e atualiza o estoque
 */
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

        // Cria objeto de item vendido
        $venda_itens = new VendaItens(
            0,
            $id_venda,
            $id_item,
            $quantidade_vendida,
        );

        // Insere o item na tabela vendas_itens
        $sql = "INSERT INTO `vendas_itens`(`id_venda`, `id_item`, `quantidade`)
                VALUES (:id_venda, :id_item, :quantidade)";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(
            ":id_venda",
            $venda_itens->getIdVenda(),
            PDO::PARAM_INT,
        );
        $stmt->bindValue(":id_item", $venda_itens->getIdItem(), PDO::PARAM_INT);
        $stmt->bindValue(
            ":quantidade",
            $venda_itens->getQuantidade(),
            PDO::PARAM_STR,
        );

        if (!$stmt->execute()) {
            throw new Exception("Falha ao inserir item da venda.");
        }

        // Atualiza o estoque do item
        $sql_update = "UPDATE `itens`
                       SET `quant` = `quant` - :quantidade
                       WHERE `id_item` = :id_item";

        $stmt_update = $con->prepare($sql_update);
        $stmt_update->bindValue(
            ":quantidade",
            $venda_itens->getQuantidade(),
            PDO::PARAM_STR,
        );
        $stmt_update->bindValue(
            ":id_item",
            $venda_itens->getIdItem(),
            PDO::PARAM_INT,
        );

        if (!$stmt_update->execute()) {
            throw new Exception(
                "Falha ao atualizar o estoque do item ID: {$venda_itens->getIdItem()}",
            );
        }
    }
}

/**
 * Cadastra os métodos de pagamento utilizados na venda
 */
function insert_metodo_pag(int $id_venda)
{
    global $con;

    $metodos_pagamento = $_SESSION["metodos_pagamento"] ?? [];

    if (empty($metodos_pagamento)) {
        return; // sem nada para cadastrar
    }

    foreach ($metodos_pagamento as $metodo) {
        // Se houver cartão, adiciona a informação ao método (opcional)
        if (!empty($p["cartao"])):
            $metodo["metodo"] .= ["cartao"];
        endif;
        $class_metPag = new MetodoPagamento(
            0,
            $id_venda,
            $metodo["metodo"],
            $metodo["valor"],
        );

        $sql = "INSERT INTO `metodos_pag`(`id_venda`, `metodo`, `valor_pago`)
                VALUES (:id_venda, :metodo, :valor_pago)";

        $stmt = $con->prepare($sql);

        $stmt->bindValue(
            ":id_venda",
            $class_metPag->getIdVenda(),
            PDO::PARAM_INT,
        );
        $stmt->bindValue(":metodo", $class_metPag->getMetodo(), PDO::PARAM_STR);
        $stmt->bindValue(
            ":valor_pago",
            $class_metPag->getValorPago(),
            PDO::PARAM_STR,
        );

        if (!$stmt->execute()) {
            throw new Exception(
                "Falha ao inserir método de pagamento da venda.",
            );
        }
    }
}

/**
 * Limpa os dados da venda da sessão e redireciona para o PDV, se necessário
 */
function limpar_venda($redirecionar)
{
    unset($_SESSION["itens"]);
    unset($_SESSION["total"]);
    unset($_SESSION["subtotal"]);
    unset($_SESSION["troco"]);
    unset($_SESSION["metodos_pagamento"]);
    unset($_SESSION["comanda"]);
    if ($redirecionar) {
        header("Location: ../../view/pdv.php");
    }
    exit();
}

function adicionar_comanda($codigo_comanda)
{
    $comanda = verificar_comanda($codigo_comanda);
    if (!$comanda) {
        echo "
        <script>
            alert('Comanda não encontrada ou fechada.');
            window.location.href='../../view/pdv.php';
        </script>";
        exit();
    }

    if (!empty($_SESSION["comanda"])) {
        echo "
        <script>
            alert('Uma comanda já foi incluída. Caso queira adicionar outra comanda, é necessário cancelar a venda.');
            window.location.href='../../view/pdv.php';
        </script>";
        exit();
    }

    $itens = buscar_itens_comanda($codigo_comanda);
    if ($itens) {
        foreach ($itens as $item) {
            $_SESSION["itens"][] = $item;
        }
    }

    $_SESSION["comanda"] = $codigo_comanda;

    header("Location: ../../view/pdv.php");
    exit();
}
function verificar_comanda($id_comanda)
{
    global $con;

    $sql =
        "SELECT * FROM comandas WHERE id_comanda = :id_comanda AND aberta = '1'";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id_comanda", $id_comanda, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC); // pega uma linha

        if ($resultado) {
            // Achou a comanda
            return $resultado;
        } else {
            // Não achou nada
            return false;
        }
    } catch (PDOException $e) {
        // Tratar o erro
        echo "
        <script>
            alert('Erro ao buscar comanda: {$e->getMessage()}');
        </script>";
        return false;
    }
}

function buscar_itens_comanda($id_comanda)
{
    global $con;

    $sql =
        "SELECT id_item, quantidade FROM comanda_itens WHERE id_comanda = :id_comanda";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id_comanda", $id_comanda, PDO::PARAM_INT);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$resultado) {
        return [];
    }

    $itens = [];
    foreach ($resultado as $res) {
        $item = procurarItem($res["id_item"], null);
        if ($item) {
            $item["quantidade"] = $res["quantidade"];
            $itens[] = $item;
        }
    }
    return $itens;
}

function fechar_comanda($id)
{
    global $con;

    $sql = "UPDATE comandas SET aberta = 0 WHERE id_comanda = :id_comanda";

    $stmt = $con->prepare($sql);
    $stmt->bindValue(":id_comanda", $id, PDO::PARAM_INT);

    if ($stmt->execute()):
        return;
    else:
        throw new Exception("Não foi possível fechar a comanda de ID: $id.");
    endif;
}
