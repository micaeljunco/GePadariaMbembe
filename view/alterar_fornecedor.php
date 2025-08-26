<?php
    session_start();
    require_once __DIR__."/../controller/fornecedores/controllerFornecedores.php";  
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Fornecedor</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <h2>Alterar Fornecedor</h2>
    <form action="alterar_fornecedor.php" method="POST">
        <label for="busca_fornecedor">Digite o ID ou o nome do usuário:</label>
        <input type="text" class="form-control" placeholder="Insira ID ou Nome" id="busca_fornecedor" name="busca_fornecedor" required onkeyup="buscarSugestoes()">

        <!-- Div para exibir sugestoes de fornecedor -->
         <div id="sugestoes">

         </div>
         <button type="submit" class="btn btn-outline-warning">Buscar</button>
    </form>
    <?php if($fornecedor): ?>
        <!-- Formulario para alterar o fornecedor -->
        <form action="#" method="POST">
            <input type="hidden" name="id_fornecedor" value="<?=htmlspecialchars($fornecedor['id_fornecedor'])?>">

            <label for="nome_fornecedor">Nome:</label>
            <input type="text" class="form-control" name="nome_fornecedor" id="nome_fornecedor" value="<?=htmlspecialchars($fornecedor['nome_fornecedor'])?>" required>

            <label for="telefone">Telefone:</label>
            <input type="tel" class="form-control" id="telefone" name="telefone" value="<?=htmlspecialchars($fornecedor['ddd']);?><?=htmlspecialchars($fornecedor['numero']);?>" required>

            <label for="cnpj">CNPJ:</label>
            <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?=htmlspecialchars($fornecedor['cnpj']);?>" required>
        
            <button type="submit" class="btn btn-outline-warning">Alterar</button>
            <button type="reset" class="btn btn-outline-warning">Cancelar</button>
        </form>
    <?php endif; ?>
    <a href="principal.php">Voltar</a>
         
</body>
</html>