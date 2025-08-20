<?php
require_once("conexao.php");

$nome_novo = $_POST["nome"];
$email_novo = $_POST["email"];
$cargo_novo = $_POST["cargo"];
$id_usuario = $_POST["id_usuario"];

$sql = "SELECT nome_usuario, email, id_cargo FROM usuarios WHERE id_usuario = :id_usuario";
$stmt = $con->prepare($sql);
$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if($usuario["nome_usuario"] == $nome_novo && $usuario["email"] == $email_novo && $usuario["id_cargo"] == $cargo_novo){
    echo "<script>alert('Você não pode atualizar o mesmo nome e senha!');window.location.href='../html/usuarios.php'</script>";
    exit();
}else{
    $sql = "UPDATE usuarios SET nome_usuario = :nome_novo, email = :email_novo, id_cargo = :cargo_novo WHERE id_usuario = :id_usuario";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":nome_novo", $nome_novo, PDO::PARAM_STR);
    $stmt->bindParam(":email_novo", $email_novo, PDO::PARAM_STR);
    $stmt->bindParam(":cargo_novo", $cargo_novo, PDO::PARAM_INT);
    $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('Usuario atualizado com Sucesso!');window.location.href='../html/usuarios.php'</script>";
        exit();
    }
}






?>