<?php
//não esqueça que precisa do wamp ou xampp
//definindo variaveis para conexao
$host = "localhost";
$user = "root";
$password = "";
$bd = "teste";

//conectando com o banco
$con = mysqli_connect($host, $user, $password); //variavel de conexao, para chamar o banco
$banco = mysqli_select_db($con, $bd); //seleciona o banco a ser conectado

//Mensagem se a conexao falhar

if(mysqli_connect_errno()){
    die("falha de conexao com o banco de dados:". mysqli_connect_error(). " ( ". mysqli_connect_errno(). " )");
}




?>