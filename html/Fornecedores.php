<?php
session_start();
require_once '../PHP/conexao.php';

// Se o formulario for enviado busca o fornecedor pelo id ou nome
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    // Verifica se a busca é um numero ou um nome
    if(is_numeric($busca)){
        $sql = "SELECT * FROM fornecedores 
                WHERE id_fornecedor = :busca 
                ORDER BY nome_fornecedor ASC";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM fornecedores 
                WHERE nome_fornecedor LIKE :busca 
                ORDER BY nome_fornecedor ASC";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':busca', "%$busca%", PDO::PARAM_STR);
    }
} else {
    // Query normal - CORRIGIDO e LEGÍVEL
    $sql = "SELECT fornecedores.*, telefone.numero
            FROM fornecedores 
            LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone 
            ORDER BY fornecedores.nome_fornecedor ASC";
    $stmt = $con->prepare($sql);
}

$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <?php if(!empty($fornecedores)):  ?>
            <table class="table">
                <thead>
                    <tr>    
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($fornecedores as $fornecedor) :?>
                <tr>
                    <td><?=htmlspecialchars($fornecedor['id_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['nome_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['id_telefone'])?></td>
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
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nehum Fornecedor encontrado.</p>
        <?php endif; ?>
        <br>
        <a href="principal.php">Voltar</a>

        </div>

    </main>
    
</body>
</html>
