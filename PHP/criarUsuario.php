<?php
require_once("conexao.php");

$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$cpf = $_POST["cpf"];
$cargo = $_POST["cargo"];

$sql = "INSERT INTO usuarios(nome_usuario, CPF, email, senha, id_cargo) VALUES(:nome, :cpf, :email, :senha, :id_cargo)";
$stmt = $con->prepare($sql);
$stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
$stmt->bindParam(":cpf", $cpf, PDO::PARAM_STR);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
$stmt->bindParam(":id_cargo", $cargo, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "<script>alert('Usuario cadastrado com sucesso!');window.location.href='../html/usuarios.php'</script>";
    exit();
}

?>