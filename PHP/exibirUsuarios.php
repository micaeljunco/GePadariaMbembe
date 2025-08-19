<?php
require_once("conexao.php");

$sql = "SELECT * FROM usuarios ORDER BY id_usuario";
$stmt = $con->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_cargo = "SELECT nome_cargo FROM cargos ORDER BY nome_cargo";
$stmt = $con->prepare($sql_cargo);
$stmt->execute();
$cargos = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>