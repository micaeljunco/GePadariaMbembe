<?php
require_once __DIR__ . "/../../model/telefone/classTelefone.php";
require_once __DIR__ . "/../../conexao.php";

/**
 * Função para cadastrar um novo telefone no banco.
 * Recebe DDD e número como parâmetros.
 * Retorna o ID do telefone inserido ou false em caso de erro.
 */
function cadastrar_telefone($ddd, $numero, $id_fornecedor)
{
    global $con; // Usa a variável global da conexão PDO

    // Cria um objeto Telefone com id 0 (novo)
    $telefone = new Telefone(
        0,
        $ddd,
        $numero,
        $id_fornecedor
    );

    // Prepara o comando SQL para inserir o telefone
    $sql = "INSERT INTO telefone(ddd, numero, id_fornecedor)
        VALUES (:ddd, :numero, :id_fornecedor)";

    $stmt = $con->prepare($sql);
    // Define os valores dos parâmetros usando os getters do objeto Telefone
    $stmt->bindValue(":ddd", $telefone->getDDD(), PDO::PARAM_STR);
    $stmt->bindValue(":numero", $telefone->getNumero(), PDO::PARAM_STR);
    $stmt->bindValue(":id_fornecedor", $telefone->getIdFornecedor(), PDO::PARAM_INT);

    try {
        // Executa a query
        $stmt->execute();
        // Retorna o último ID inserido (id do novo telefone)
        return $con->lastInsertId();

    } catch (PDOException $e) {
        // Em caso de erro, exibe alerta com a mensagem e retorna false
        echo "<script>alert('Erro: " . $e->getMessage() . "')</script>";
        return false;
    }
}

/**
 * Função para editar um telefone existente.
 * Recebe o ID do telefone, DDD e número para atualização.
 * Retorna true se atualizado com sucesso ou false em caso de erro.
 */
function editar_telefone($id_telefone, $ddd, $numero, $id_fornecedor): bool {
    global $con;

    $telefone = new Telefone($id_telefone, $ddd, $numero, $id_fornecedor);

    $sql = "UPDATE telefone 
            SET ddd = :ddd, numero = :numero, id_fornecedor = :id_fornecedor
            WHERE id_telefone = :id_telefone";
    $stmt = $con->prepare($sql);

    $stmt->bindValue(":ddd", $telefone->getDDD(), PDO::PARAM_STR);
    $stmt->bindValue(":numero", $telefone->getNumero(), PDO::PARAM_STR);
    $stmt->bindValue(":id_fornecedor", $telefone->getIdFornecedor(), PDO::PARAM_INT);
    $stmt->bindValue(":id_telefone", $telefone->getIDTelefone(), PDO::PARAM_INT);

    try {
        $stmt->execute();
        // echo "<script>alert('Telefone editado com sucesso!')</script>";
        return true;
    } catch (PDOException $e) {
        echo "<script>alert('Erro: " . $e->getMessage() . "')</script>";
        return false;
    }
}