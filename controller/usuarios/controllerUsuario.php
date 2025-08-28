<?php
require_once __DIR__ ."/../../model/usuario/classUsuario.php";
require_once __DIR__ ."/../../conexao.php";

function buscar_usuario(): array {
    global $con;

    $sql = "SELECT * FROM usuarios ORDER BY id_usuario";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    return $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function buscar_cargos(): array {
    global $con;

    $sql_cargo = "SELECT * FROM cargos ORDER BY nome_cargo";
    $stmt = $con->prepare($sql_cargo);
    $stmt->execute();
    return $cargos = $stmt->fetchALL(PDO::FETCH_ASSOC);
}


function cadastrar_usuario(): void{
    global $con;

    try{

        $nome = new Nome($_POST["nome"]);
        $cpf = new Cpf($_POST["cpf"]);
        $email = new Email($_POST["email"]);
        $senha = new Senha($_POST["senha"]);
        $cargo = (int) $_POST["cargo"];

        $senhaHash = $senha->gerarHash();

        $usuario = new Usuario($nome, $cpf, $email, $senhaHash, $cargo, 0);

        $sql = "INSERT INTO usuarios(nome_usuario, CPF, email, senha, id_cargo, ativo)VALUES (:nome_usuario, :CPF, :email, :senha, :id_cargo, 1)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":nome_usuario", $usuario->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(":CPF", $usuario->getCpf(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":senha", $senhaHash, PDO::PARAM_STR);
        $stmt->bindValue(":id_cargo", $usuario->getIdCargo(), PDO::PARAM_INT);
        
        if(!$stmt->execute()){
            echo "<script>alert('Não foi possivel cadastrar o usuario, Tente novamente!');window.location.href='../view/usuarios.php'</script>";
            exit();
        }
        echo "<script>alert('Usuario cadastrado com sucesso!');window.location.href='../../view/usuarios.php'</script>";
            exit();


    }catch(InvalidArgumentException $e){
        echo "<script>alert('". addslashes($e->getMessage()). "');window.location.href='../../view/usuarios.php'</script>";
        exit();
    }
}

function editar_usuario(): void{
    global $con;

    try{
        $id_usuario = (int) $_POST["id_usuario"];

        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $infoUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

        $nome_novo = new Nome($_POST["nome"]);
        $email_novo = new Email($_POST["email"]);
        $cargo_novo = (int) $_POST["cargo"]; 
        $cpf = new Cpf($infoUsuario["CPF"]);
        $senhaHash = $infoUsuario["senha"];


        $usuario = new Usuario($nome_novo, $cpf , $email_novo, $senhaHash, $cargo_novo, $id_usuario);
        
        $sql = "UPDATE usuarios SET nome_usuario = :nome_novo, email = :email_novo, id_cargo = :cargo_novo WHERE id_usuario = :id_usuario";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":nome_novo", $usuario->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(":email_novo", $usuario->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":cargo_novo", $usuario->getIdCargo(), PDO::PARAM_INT);
        $stmt->bindValue(":id_usuario", $usuario->getIdUsuario(), PDO::PARAM_INT);

        if($stmt->execute()){
            echo "<script>alert('Usuario atualizado com Sucesso!');window.location.href='../../view/usuarios.php'</script>";
            exit();
        }


    }catch(InvalidArgumentException $e){
        echo "<script>alert('". addslashes($e->getMessage())."');window.location.href='../../view/usuarios.php'</script>";
    }


}

function excluir_usuario($id_usuario): void{
    global $con;

    
    $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
    if(!$stmt->execute()){
        echo "<script>alert('Ocorreu um erro ao excluir o usuario!');window.location.href='../../view/usuarios.php'</script>";
        exit();
    }
    $stmt->execute();
    echo "<script>alert('usuario excluido com sucesso!');window.location.href='../../view/usuarios.php'</script>";
    exit();
}

function pesquisar_usuario(): void{
    global $con;
    $busca = $_POST["busca"];
    if(is_numeric($busca)){
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id_usuario", $busca, PDO::PARAM_INT);
    $stmt->execute();
    exit();
    }

}