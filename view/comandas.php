<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandas</title>
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/bootstrap.min.css">

    <link rel="stylesheet" href="../css/padrao.css">
    <link rel="stylesheet" href="../css/listaPadrao.css">
    <link rel="stylesheet" href="../css/comandas.css">
</head>
<body> 
    <?php require_once __DIR__."/usuarios.php"?>
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
    
</body>
</html>