<?php
require_once __DIR__ . "/../../model/usuario/classUsuario.php";
require_once __DIR__ . "/../../conexao.php";

// Função que busca todos os usuários no banco, ordenados pelo id_usuario
function buscar_usuario(): array
{
    global $con; // Usa a conexão global com o banco

    $sql = "SELECT * FROM usuarios ORDER BY id_usuario DESC";
    $stmt = $con->prepare($sql); // Prepara a query para execução segura
    $stmt->execute();

    // Retorna todos os usuários como array associativo
    return $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função que busca todos os cargos no banco, ordenados pelo nome_cargo
function buscar_cargos(): array
{
    global $con;

    $sql_cargo = "SELECT * FROM cargos ORDER BY nome_cargo";
    $stmt = $con->prepare($sql_cargo);
    $stmt->execute();

    return $cargos = $stmt->fetchALL(PDO::FETCH_ASSOC);
}

// Função para cadastrar um novo usuário no banco
function cadastrar_usuario(): void
{
    global $con;

    try {
        // Instancia objetos de valor para validação dos dados enviados via POST
        $nome = new Nome($_POST["nome"]); // Classe Nome valida formato e conteúdo do nome
        $cpf = new Cpf($_POST["cpf"]); // Classe Cpf valida o CPF
        $email = new Email($_POST["email"]); // Classe Email valida o email
        $senha = new Senha($_POST["senha"]); // Classe Senha valida a senha
        $cargo = (int) $_POST["cargo"]; // Converte para inteiro o id do cargo

        // Gera hash seguro para a senha (ex: bcrypt)
        $senhaHash = $senha->gerarHash();

        // Cria objeto Usuario encapsulando todos os dados, incluindo a senha já hasheada
        $usuario = new Usuario($nome, $cpf, $email, $senhaHash, $cargo, 0);

        // Query para inserir um novo usuário, usando prepared statements para evitar SQL Injection
        $sql =
            "INSERT INTO usuarios(nome_usuario, CPF, email, senha, id_cargo) VALUES (:nome_usuario, :CPF, :email, :senha, :id_cargo)";
        $stmt = $con->prepare($sql);
        // Liga os parâmetros com seus respectivos valores
        $stmt->bindValue(":nome_usuario", $usuario->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(":CPF", $usuario->getCpf(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":senha", $senhaHash, PDO::PARAM_STR);
        $stmt->bindValue(":id_cargo", $usuario->getIdCargo(), PDO::PARAM_INT);

        // Executa a query e verifica sucesso
        if (!$stmt->execute()) {
            // Em caso de falha, exibe mensagem e redireciona
            echo "<script>alert('Não foi possivel cadastrar o usuario, Tente novamente!');window.location.href='../view/usuarios.php'</script>";
            exit();
        }
        // Em caso de sucesso, exibe mensagem e redireciona
        echo "<script>alert('Usuario cadastrado com sucesso!');window.location.href='../../view/usuarios.php'</script>";
        exit();
    } catch (InvalidArgumentException $e) {
        // Captura exceções de validação das classes (ex: Nome, Cpf) e exibe mensagem ao usuário
        echo "<script>alert('" .
            addslashes($e->getMessage()) .
            "');window.location.href='../../view/usuarios.php'</script>";
        exit();
    }
}

// Função para editar dados de um usuário existente
function editar_usuario(): void
{
    global $con;

    try {
        $id_usuario = (int) $_POST["id_usuario"];

        // Busca informações atuais do usuário para preservar dados que não serão alterados
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $infoUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Cria novos objetos de valor com os dados atualizados enviados pelo formulário
        $nome_novo = new Nome($_POST["nome"]);
        $email_novo = new Email($_POST["email"]);
        $cargo_novo = (int) $_POST["cargo"];
        // Mantém CPF e senha antigos pois não são alterados nesse método
        $cpf = new Cpf($infoUsuario["CPF"]);
        $senhaHash = $infoUsuario["senha"];

        // Cria objeto Usuario com os dados atualizados e os antigos preservados
        $usuario = new Usuario(
            $nome_novo,
            $cpf,
            $email_novo,
            $senhaHash,
            $cargo_novo,
            $id_usuario,
        );

        // Atualiza os dados do usuário no banco
        $sql =
            "UPDATE usuarios SET nome_usuario = :nome_novo, email = :email_novo, id_cargo = :cargo_novo WHERE id_usuario = :id_usuario";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":nome_novo", $usuario->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(":email_novo", $usuario->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":cargo_novo", $usuario->getIdCargo(), PDO::PARAM_INT);
        $stmt->bindValue(
            ":id_usuario",
            $usuario->getIdUsuario(),
            PDO::PARAM_INT,
        );

        if ($stmt->execute()) {
            echo "<script>alert('Usuario atualizado com Sucesso!');window.location.href='../../view/usuarios.php'</script>";
            exit();
        }
    } catch (InvalidArgumentException $e) {
        // Captura erros de validação e exibe mensagem ao usuário
        echo "<script>alert('" .
            addslashes($e->getMessage()) .
            "');window.location.href='../../view/usuarios.php'</script>";
    }
}

// Função para excluir um usuário dado o id
function excluir_usuario($id_usuario): void
{
    global $con;

    // Prepara e executa query DELETE para remover usuário
    $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        echo "<script>alert('Ocorreu um erro ao excluir o usuario!');window.location.href='../../view/usuarios.php'</script>";
        exit();
    }

    echo "<script>alert('usuario excluido com sucesso!');window.location.href='../../view/usuarios.php'</script>";
    exit();
}

// Função que realiza pesquisa de usuários por id ou nome
function pesquisar_usuario(): array
{
    global $con;

    // Se o campo de busca está vazio, retorna todos os usuários
    if (!isset($_POST["busca"]) || empty(trim($_POST["busca"]))) {
        return buscar_usuario();
    }

    $busca = trim($_POST["busca"]);

    if (is_numeric($busca)) {
        // Caso a busca seja numérica, pesquisa pelo id exato do usuário
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":id_usuario", $busca, PDO::PARAM_INT);
    } else {
        // Caso contrário, realiza busca parcial no nome usando LIKE para facilitar a busca
        $sql = "SELECT * FROM usuarios WHERE nome_usuario LIKE :nome_usuario";
        $stmt = $con->prepare($sql);
        // Adiciona % no final para buscar nomes que começam com o termo digitado
        $nomeParam = $busca . "%";
        $stmt->bindParam(":nome_usuario", $nomeParam, PDO::PARAM_STR);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
