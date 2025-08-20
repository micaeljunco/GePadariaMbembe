<?php
require_once("../PHP/conexao.php");

$id_usuario = $_POST["id_usuario"];

$sql = "UPDATE usuarios SET ativo = 0 WHERE id_usuario = :id_usuario";
$stmt = $con->prepare($sql);
$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

if( $stmt->execute() ){
    echo "<script>alert('Usuario inativado com sucesso!');window.location.href='../html/usuarios.php'</script>";
    exit();
}
?>