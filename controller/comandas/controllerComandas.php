<?php
require_once __DIR__ . "/../../model/itens/classItens.php";
// require_once __DIR__ . "/../../model/comandas/classComanda.php";
require_once __DIR__ . "/../../conexao.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Garante que sempre tenha o total calculado
recalcular_total();

// 🔹 Função para adicionar item na comanda
function adicionar_item()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item'])) {
        $valor = trim($_POST['item']);
        $idItem = null;
        $nomeItem = null;

        if (is_numeric($valor)) {
            $idItem = $valor;
        } else {
            $nomeItem = $valor;
        }

        $quantidade = intval($_POST['quantidade'] ?? 1);

        if ($nomeItem !== '' || $idItem !== null) {
            $item = procurarItem($idItem, $nomeItem);
            if ($item) {
                $item['quantidade'] = $quantidade;
                $_SESSION['comanda_itens'][] = $item;
            }
        }

        header("Location: ../../view/comandas.php");
        exit;
    }
}

// 🔹 Função para procurar item no banco
function procurarItem($id = null, $nome_item = null)
{
    global $con;
    $sql = "SELECT * FROM itens WHERE 1=1";
    if ($id !== null && $id !== '') {
        $sql .= " AND id_item = :id_item";
    }
    if ($nome_item !== null && $nome_item !== '') {
        $sql .= " AND nome_item = :nome_item";
    }

    $stmt = $con->prepare($sql);

    if ($id !== null && $id !== '') {
        $stmt->bindParam(':id_item', $id, PDO::PARAM_INT);
    }
    if ($nome_item !== null && $nome_item !== '') {
        $stmt->bindParam(':nome_item', $nome_item, PDO::PARAM_STR);
    }

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 🔹 Função para remover item
function removerItem($index)
{
    if (isset($_SESSION['comanda_itens'][$index])) {
        unset($_SESSION['comanda_itens'][$index]);
        $_SESSION['comanda_itens'] = array_values($_SESSION['comanda_itens']);
    }
    header("Location: ../../view/comandas.php");
    exit;
}

// 🔹 Função para recalcular total
function recalcular_total()
{
    $total = 0.0;
    if (isset($_SESSION['comanda_itens'])) {
        foreach ($_SESSION['comanda_itens'] as $item) {
            $total += $item['val_unitario'] * $item['quantidade'];
        }
    }
    $_SESSION['comanda_total'] = $total;
}

// 🔹 Função para limpar comanda
function limpar_comanda()
{
    unset($_SESSION['comanda_itens']);
    unset($_SESSION['comanda_total']);
    header("Location: ../../view/comandas.php");
    exit;
}

// 🔹 Roteamento simples de ações
if (isset($_GET['remover'])) {
    removerItem(intval($_GET['remover']));
}

if (isset($_POST['limpar'])) {
    limpar_comanda();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item'])) {
    adicionar_item();
}
