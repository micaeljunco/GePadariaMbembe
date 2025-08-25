<?php
// require_once __DIR__ . "/../../model/itens/classItens.php";
require_once __DIR__ . "/../../conexao.php";

function fornecedor_item(int $item_id_fornecedor): string {
    global $con;

    $sql = "SELECT nome_fornecedor FROM fornecedores WHERE id_fornecedor = :item_id_fornecedor";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(":item_id_fornecedor", $item_id_fornecedor, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fornecedor) {
            return "Nenhum";
        }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }

    return $fornecedor['nome_fornecedor'];
}
