<?php
require_once __DIR__ ."/../../model/telefone/classTelefone.php";
require_once __DIR__ . "/../../conexao.php";

function cadastrar_telefone($ddd, $numero) {
    global $con;

    $telefone = new Telefone(
        0,
        $ddd,
        $numero
    );

    $sql = "INSERT INTO telefone(ddd, numero)
        VALUES (:ddd, :numero)";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(":ddd", $telefone->getDDD());
    $stmt->bindValue(":numero", $telefone->getNumero());

    try {
        $stmt->execute();
        return $con->lastInsertId();

    } catch (PDOException $e) {
        echo "<script>alert('Erro: ". $e->getMessage() . "')</script>";
        return false;
    }
}

function editar_telefone($id_telefone, $ddd, $numero): int|false {
    global $con;

    $telefone = new Telefone(
        $id_telefone,
        $ddd,
        $numero
    );

    $sql = "UPDATE `telefone` SET `ddd` = :ddd, `numero` = :numero WHERE `id_telefone` = :id_telefone";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(":ddd", $telefone->getDDD());
    $stmt->bindValue(":numero", $telefone->getNumero());
    $stmt->bindValue(":id_telefone", $telefone->getIDTelefone());

    try {
        $stmt->execute();
        echo "<script>alert('Telefone editado com sucesso!')</script>";
        return true;
    } catch (PDOException $e) {
        echo "<script>alert('Erro: " . $e->getMessage() . "')</script>";
        return false;
    }
}

