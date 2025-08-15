<?php
session_start();
require_once 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];


$sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
$stmt = $con->prepare($sql);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    $_SESSION["nome"] = $usuario['nome'];
    $_SESSION["id_cargo"] = $usuario["id_cargo"];
    
    echo "<script>alert('Login Bem sucedido!');window.location.href='../html/home.php';</script>";
}else{
    echo "<script>alert('E-mail ou Senha incorreta! Tente novamente');window.location.href='../html/index.php';</script>";
}

?>