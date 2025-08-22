<?php
require_once "../PHP/conexao.php";

function consulta_fornecedores(): array|string
{
    global $con;
    $sql = "SELECT * FROM `fornecedores`";
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