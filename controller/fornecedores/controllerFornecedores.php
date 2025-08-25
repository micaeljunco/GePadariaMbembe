<?php
// require_once __DIR__ . "/../../model/itens/classItens.php";
require_once __DIR__ . "/../../conexao.php";

function consulta_fornecedores(): array|string
{
    global $con;

    $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
    FROM fornecedores 
    LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone 
    ORDER BY fornecedores.nome_fornecedor ASC";
    $stmt = $con->prepare($sql);

    try {
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return "Não foi possível realizar a consulta.";
}
function busca_fornecedores() {
    global $con;
    // Se o formulario for enviado busca o fornecedor pelo id ou nome
if($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['busca'])){
    $busca = trim($_GET['busca']);

    // Verifica se a busca é um numero ou um nome
    if(is_numeric($busca)){
        $sql = "SELECT * FROM fornecedores 
                WHERE id_fornecedor = :busca 
                ORDER BY nome_fornecedor ASC";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM fornecedores 
                WHERE nome_fornecedor LIKE :busca 
                ORDER BY nome_fornecedor ASC";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':busca', "%$busca%", PDO::PARAM_STR);
    }
} else {
    // Query normal - CORRIGIDO e LEGÍVEL
    $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
            FROM fornecedores 
            LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone 
            ORDER BY fornecedores.nome_fornecedor ASC";
    $stmt = $con->prepare($sql);
}
header("Location: ../../view/fornecedor.php");

$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
}