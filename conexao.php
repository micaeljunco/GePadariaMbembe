<?php
$dsn = "mysql:host=localhost;dbname=sa_padaria_mokele_revisao;charset=utf8";
$user = "root";
$password = "";

try{
    $con = new PDO($dsn, $user, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}catch(PDOException $e){
    echo "Erro ao conectar com o Banco: ".$e->getMessage();
}
?>