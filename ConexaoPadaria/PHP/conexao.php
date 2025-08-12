<?php
$dsn = "mysql:host=localhost;dbname=sa_padaria_mokele;charset=utf8";
$user = "root";
$password = "";

try{
    $con = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
}catch(PDOException $e){
    echo "ERRO PAE: ".$e->getMessage();
}
?>