<?php
session_start();
require_once __DIR__ ."/../../conexao.php";
require_once __DIR__ ."/email.php";


function recuperar_senha(): void{
    global $con;
    if($_SERVER["REQUEST_METHOD"]== "POST"){
        $email = $_POST['email'];
    
        //VERIFICA SE O EMAIL EXISTE NO BANCO DE DADOS
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if($usuario){
            //GERA UMA SENHA SUPER TEMPORARIA
            $senha_temporaria = gerarSenhaTemporaria();
            $senha_hash = password_hash($senha_temporaria, PASSWORD_DEFAULT);
    
            //ATUALIZA A SENHA DO USUARIO NO BANCO
            $sql="UPDATE usuarios SET senha = :senha,senha_temporaria = TRUE WHERE email = :email";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":senha",$senha_hash);
            $stmt->bindParam(":email",$email);
            $stmt->execute();
    
            //SIMULA O ENVIO DO EMAIL(GRAVA EM TXT)
            simularEnvioEmail($email, $senha_temporaria);
            echo "<script>alert('Uma senha temporaria foi gerada e enviada(simulação). Verifique o arquivo emails_simulados.txt');window.location.href='../../index.php';</script>";
        }else{
            echo "<script>alert('E-mail não encontrado!');</script>";
        }
    }
}

recuperar_senha();

?>