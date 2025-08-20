<?php
require_once "../PHP/conexao.php";

function consulta_fornecedores() {
    global $con;
    $sql= "SELECT * FROM fornecedores";
    $stmt= $con->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
