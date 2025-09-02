<?php
session_start();

require_once __DIR__ ."/../controller/permissions/permission.php";
verificar_logado();
verificar_acesso($_SESSION["id_cargo"]);



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandas</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/listaPadrao.css">
    <link rel="stylesheet" href="../src/css/comandas.css">
</head>
<body>
    <?= include "./partials/sidebar.html" ?>
    <main class="container">
        <div class="nomePag m-0">
            <h1>Emissão de Comandas</h1>
        </div>

        <div class="interacao d-flex">
            <form action="comandas.php" class="d-flex">
                <input type="text" class="form-control" placeholder="Digite o nome ou ID do produto">
                <input type="text" class="form-control" placeholder="Digite a quantidade do produto">
                <button type="submit" class="btn btn-outline-warning">adicionar</button>
            </form>
            <form action="../controller/comandas/emitirComandas.php" class="d-flex justify-content-end" id="form-paia">
                <button class="btn btn-outline-warning">Emitir Comanda</button>
            </form>
        </div>

        <div class="w-100"> 
            <table class="table-hover table">
                <thead>
                    <th>Nome Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </thead>
            </table>
        </div>

    </main>
    <?= include "./partials/footer.html" ?>
</body>
</html>
