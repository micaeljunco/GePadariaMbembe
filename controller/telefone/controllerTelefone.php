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
