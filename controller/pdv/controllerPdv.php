<?php
require_once __DIR__ . "/../../model/itens/classItens.php";
require_once __DIR__ . "/../../conexao.php";
session_start();
// adicionar_item(); // ← ESSENCIAL
function adicionar_item(){
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
function valor_total() {
    $totalGeral = 0;
    foreach($_SESSION['item'] as $item):
    $preco = floatval($item['preco']);
    $quantidade = intval($item['quantidade'] ?? 1);
    $subtotal = $preco * $quantidade;
    $totalGeral += $subtotal;
    
    endforeach;
}
    
    // Função para limpar a lista (opcional)
    if (isset($_GET['limpar']) && $_GET['limpar'] == 1) {
        $_SESSION['itens'] = [];
        header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
        exit;
    }
    header("Location: ../../view/pdv.php");
}
function procurarItem($id){
    global $con;
    $sql = "SELECT * FROM itens WHERE id_item = :id_item";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id_item', $id);
    $stmt->execute();
    return $stmt->fetch();
}
