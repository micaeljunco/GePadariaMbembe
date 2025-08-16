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
                            <img src="../img/edit.png" alt="Editar">
                        </div>
                        <div class="excluir">
                            <img src="../img/delete.png" alt="Excluir">
                        </div>
                        </div>
                        
                    </td>
                </tbody>
            </table>

        </div>

    </main>
    
</body>
</html>