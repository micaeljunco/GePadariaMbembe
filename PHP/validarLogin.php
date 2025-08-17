<?php
session_start();
require_once 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];


$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $con->prepare($sql);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($senha, $usuario["senha"])) {
    $_SESSION["nome"] = $usuario['nome_usuario'];
    $_SESSION["id_cargo"] = $usuario["id_cargo"];
    
    echo "<script>alert('Login Bem sucedido!');window.location.href='../html/home.php';</script>";
    exit();
}else{
    echo "<script>alert('E-mail ou Senha incorreta! Tente novamente');window.location.href='../html/index.php';</script>";
    exit();
}
?>