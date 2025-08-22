<?php
require_once "conexao.php";

function consulta_itens(): array|string
{
    global $con;
    $sql = "SELECT * FROM `itens`";
    $stmt = $con->prepare($sql);
    try {
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
    } catch (Exception $e) {
        return $e->getMessage();
    }

    return [];
}


function item_fornecedor($id)
{
    global $con;
    $sql = "SELECT `nome_fornecedor` FROM `fornecedores` WHERE id_fornecedor = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id", $id);
    try {
        if ($stmt->execute()) {
            return $stmt->fetch();

        }
    } catch (Exception $e) {
        return $e->getMessage();
    }

    return [];
}
