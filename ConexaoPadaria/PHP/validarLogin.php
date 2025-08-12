<?php
    session_start();
    include_once 'conexao.php';
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = $_POST["nome"];
        $senha = $_POST["senha"];
        
        $sql = "SELECT * FROM usuario WHERE nome_usuario = :nome AND senha =:senha";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario){
            $_SESSION["nome"] = $nome;
            echo "<script>alert('Login realizado com sucesso');window.location.href='../html/home.php'</script>";
            exit();
        }else{
            echo "<script>alert('Falha no login');window.location.href='../html/index.php'</script>";
            exit();
        }
    }
?>