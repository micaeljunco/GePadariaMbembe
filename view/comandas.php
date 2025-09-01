<?php
session_start();

if (
    !isset($_SESSION["nome"]) ||
    !isset($_SESSION["id_usuario"]) ||
    !isset($_SESSION["id_cargo"])
) {
    // Melhor que usar JS, pois o usuario poderia desativá-lo.
    header("Location: ./");
    exit();
}
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
        <div class="nomePag">
            <h1>Emissão de Comandas</h1>
        </div>
        <div class="interacao d-flex">
            <form action="comandas.php" class="d-flex">
                <input type="text" class="form-control" placeholder="Digite o nome ou ID do produto">
                <input type="text" class="form-control" placeholder="Digite a quantidade do produto">
                <button type="submit" class="btn btn-outline-warning">adicionar</button>
            </form>
            <form action="../controller/comandas/emitirComandas.php">
                <button class="btn btn-outline-warning">Emitir Comanda</button>
            </form>
        </div>

    </main>
    <?= include "./partials/footer.html" ?>
</body>
</html>
