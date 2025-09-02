<?php
require_once __DIR__ . "/../../model/itens/classItens.php";
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
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes

function recalcular_total() {
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


function processa_metodos(): void {
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

function atualizar_subtotal($valor) {
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


function finalizar_compra(): void {
    limpar_venda();
}

function limpar_venda() {
    unset($_SESSION["itens"]);
    unset($_SESSION["total"]);
    unset($_SESSION["subtotal"]);
    unset($_SESSION["troco"]);
    unset($_SESSION["metodos_pagamento"]);
    header("Location: ../../view/pdv.php");
    exit;
}