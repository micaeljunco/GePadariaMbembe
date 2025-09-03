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
    <title>Historico de Vendas</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/listaPadrao.css">
    <link rel="stylesheet" href="../src/css/historicoVendas.css">
</head>
<body>
<?= include "./partials/sidebar.php" ?>
    
    <main class="container">
        <div class="nomePag">
            <h1>Historico de Vendas</h1>
        </div>
        <div class="interacao">
            <form action="" class="d-flex">
                <input type="text" name="" placeholder="Data">
                <input type="text" name="" placeholder="ID da Compra">
                <input type="text" name="" placeholder="Vendedor">
                <button type="submit">Pesquisar</button>
            </form>
        </div>

    <table class="table table-striped" border="1">
        <thead>
            <tr>
            <th scope="col">ID da venda</th>
            <th scope="col">Data</th>
            <th scope="col">Valor Total</th>
            <th scope="col">Vendedor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            </tr>
            <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            </tr>
            <tr>
            <th scope="row">3</th>
            <td>John</td>
            <td>Doe</td>
            <td>@social</td>
            </tr>
        </tbody>
</table>



    </main>
<?= include "./partials/footer.html" ?>
</body>
</html>



