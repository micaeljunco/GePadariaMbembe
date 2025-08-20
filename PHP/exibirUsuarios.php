<?php
require_once("conexao.php");

$sql = "SELECT * FROM usuarios WHERE ativo = 1 ORDER BY id_usuario";
$stmt = $con->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_cargo = "SELECT * FROM cargos ORDER BY nome_cargo";
$stmt = $con->prepare($sql_cargo);
$stmt->execute();
$cargos = $stmt->fetchALL(PDO::FETCH_ASSOC);


$cargosMapa = [
    1 => "Administrador",
    2 => "Caixa",
    3 => "Controlador de Estoque"
]
?>