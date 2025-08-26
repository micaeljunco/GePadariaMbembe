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
function busca_fornecedores()
{
    global $con;

    // Se o formulario for enviado busca o fornecedor pelo id ou nome
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["busca"])) {
        $busca = trim($_GET["busca"]);

        // Verifica se a busca é um numero ou um nome
        if (is_numeric($busca)) {
            $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
                    FROM fornecedores
                    LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone
                    WHERE id_fornecedor = :busca
                    ORDER BY nome_fornecedor ASC";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":busca", $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
                    FROM fornecedores
                    LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone
                    WHERE nome_fornecedor LIKE :busca
                    ORDER BY nome_fornecedor ASC";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":busca", "%$busca%", PDO::PARAM_STR);
        }
    } else {
        // Query normal
        $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
                FROM fornecedores
                LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone
                ORDER BY fornecedores.nome_fornecedor ASC";
        $stmt = $con->prepare($sql);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function fornecedor_item(int $item_id_fornecedor): string
{
    global $con;

    $sql =
        "SELECT nome_fornecedor FROM fornecedores WHERE id_fornecedor = :item_id_fornecedor";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(
        ":item_id_fornecedor",
        $item_id_fornecedor,
        PDO::PARAM_INT,
    );

    try {
        $stmt->execute();
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fornecedor) {
            return "Nenhum";
        }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }

    return $fornecedor["nome_fornecedor"];
}
