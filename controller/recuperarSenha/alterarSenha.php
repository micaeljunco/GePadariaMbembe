<?php
session_start();
require_once __DIR__ ."/../../conexao.php";
require_once __DIR__ ."/../../model/usuario/senha.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../");
}

$novaSenha = $_POST["novaSenha"];
$confirmar_senha = $_POST["confirmarSenha"];
$id_usuario = $_SESSION["id_usuario"];

if($novaSenha !== $confirmar_senha) {
    echo "<script>alert('As senhas não coincidem, tente novamente');window.location.href='../../view/alterarSenha.php'</script>";
    exit();
}
$novaSenha = new Senha($novaSenha);

$sql = "UPDATE usuarios set senha = :novaSenha, senha_temporaria = FALSE WHERE id_usuario = :id_usuario";
$stmt = $con->prepare($sql);
$stmt->bindValue(":novaSenha", $novaSenha->gerarHash(), PDO::PARAM_STR);
$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

if($stmt->execute()) {
    echo "<script>alert('Senha alterada com Sucesso! faça login novamente');window.location.href='../../'</script>";
    exit();
}

?>