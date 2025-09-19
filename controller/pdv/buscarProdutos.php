<?php
require_once __DIR__ . "/../../conexao.php";

header("Content-Type: application/json; charset=utf-8");

$q = $_GET["q"] ?? "";

if (strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

try {
    $sql = "SELECT id_item, nome_item, val_unitario, unidade_medida 
            FROM itens 
            WHERE nome_item LIKE :termo 
            ORDER BY nome_item ASC 
            LIMIT 10";

    $stmt = $con->prepare($sql);
    $stmt->bindValue(":termo", "%$q%", PDO::PARAM_STR);
    $stmt->execute();

    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($produtos);
} catch (Exception $e) {
    echo json_encode(["erro" => $e->getMessage()]);
}
