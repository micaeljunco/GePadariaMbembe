<?php

//Declarando variaveis de endereço e permissão ao banco
$dsn = "mysql:host=db;dbname=sa_padaria_mokele;charset=utf8";
$user = "user";
$password = "1234";

//Tentando a conexão, me caso de falha gera um erro tratado
try{
    $con = new PDO($dsn, $user, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}catch(PDOException $e){
    echo "Erro ao conectar com o Banco: ".$e->getMessage();
}
?>