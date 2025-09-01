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
function editarProduto($id_itens, $nome_item);

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

