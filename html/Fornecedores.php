<?php
    session_start();
    require_once '../PHP/conexao.php';

    // // Verifica se o usuario tem permissao de ADM ou Secretaria
    // if($_SESSION['perfil'] !=1 && $_SESSION['perfil'] !=2){
    //     echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    //     exit();
    // } 

    // ADICIONAR APÓS TER DIVISÕES DE NÍVEIS
    $usuario = []; // Inicializa a variavel para evitar erros

    // Se o formulario for enviado busca o usuario pelo id ou nome
    if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])){
        $busca = trim($_POST['busca']);

        // Verifica se a busca é um numero ou um nome
        if(is_numeric($busca)){
            $sql = "SELECT * FROM fornecedores WHERE id_fornecedores = :busca ORDER BY nome_fornecedor ASC";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        }else{
            $sql = "SELECT * FROM fornecedores WHERE nome_fornecedor LIKE :busca_nome_fornecedor ORDER BY nome_fornecedor ASC";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':busca_nome_fornecedor', "$busca%", PDO::PARAM_STR);
        }
    }else {
        $sql = "SELECT * FROM fornecedores ORDER BY nome_fornecedor ASC";
        $stmt = $con->prepare($sql);
        
    }
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores</title>
    <!-- Link do Bootstrap -->
     <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <!-- Link do CSS -->
    <link rel="stylesheet" href="../css/padrao.css">
    <link rel="stylesheet" href="../css/ListaPadrao.css">
      
</head>
<body>

    <main class="container">
        <div class="nomePag">
            <h1>Gestão de Fornecedores</h1>
        </div>

        <div class="tabela">
            <div class="interacao">
                <div class="busca">
                    <input type="text" class="form-control" placeholder="Pesquisar Fornecedores">
                    <button class="btn btn-outline-warning">Buscar</button>
                    
                </div>
                <div class="cadastro">
                    <button class="btn btn-outline-warning">Cadastrar Fornecedores</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    <td>Mensagem</td>
                    <td>Para</td>
                    <td>Testes</td>
                    <td>AIAI</td>
                    <td>
                        <div class="acoes">
                            <div class="editar">
                            <span type="submit" class="material-symbols-outlined">edit</span>
                        </div>
                        <div class="excluir">
                        <span class="material-symbols-outlined">delete</span>
                        </div>
                        </div>
                        
                    </td>
                </tbody>
            </table>

        </div>

    </main>
    
</body>
</html>