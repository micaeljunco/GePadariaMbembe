<?php
    include "conexao.php"; //conectar com o banco(o banco usado foi o mesmo da SA, aquele que esta no meu(yan) git)
    session_start(); //iniciar sessao

    //pega os campos do formulario

    $nome = $_POST["nome"];
    $senha = $_POST["senha"];

    //protege contra sql injection
    $nome = mysqli_real_escape_string($con, $nome);
    $senha = mysqli_real_escape_string($con, $senha);

    //realiza a busca no banco
    $sql = "Select * from usuario where nome_usuario = '$nome' and senha = '$senha'";
    $sql_query = $con->query($sql) or die("Erro na consulta". $con->error);

    if($sql_query->num_rows === 1){
        $usuario = $sql_query->fetch_assoc();

        $_SESSION["id"] = $usuario["ID_usuario"]; 
        $_SESSION["nome"] = $usuario["nome_usuario"];

        header("Location: ../html/home.php"); //redireciona para a home
        exit;
    }else{
        echo "Falha no login";
    }


?>