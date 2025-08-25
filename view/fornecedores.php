<?php 
require_once __DIR__ ."/../controller/fornecedores/controllerFornecedores.php";
if ($_SERVER["REQUEST_METHOD"] === "GET"){
    $fornecedores = busca_fornecedores();
} else {
    $fornecedores = consulta_fornecedores();
}

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
            
            <form action="fornecedores.php" method="GET" class="busca">
            <div class="busca">
                <input type="text" class="form-control" name="busca" placeholder="Pesquisar Fornecedores">
                <button class="btn btn-outline-warning">Buscar</button>
            </form></div>
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
                    <td>(<?=htmlspecialchars($fornecedor['ddd'])?>) <?=htmlspecialchars($fornecedor['numero'])?></td>
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
            <p>Nenhum Fornecedor encontrado.</p>
        <?php endif; ?>
        <br>
        <a href="home.php">Voltar</a>

        </div>

    </main>
    
</body>
</html>