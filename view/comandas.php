<?php
session_start(); //inicia a sessão

//Verifica o acesso do usuario atraves das funções
require_once __DIR__ . "/../controller/permissions/permission.php"; //Chamada de arquivo com as funções
verificar_logado(); //Verifica se o usuario logou
verificar_acesso($_SESSION["id_cargo"]); //Verifica o nivel de acesso para liberar as paginas corretas



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
    <link rel="icon" type="image/png" href="../src/img/icon.png">
</head>
<body>
<?= include "./partials/sidebar.php" ?>

<main class="container">
    <div class="nomePag m-0">
        <h1>Emissão de Comandas</h1>
    </div>

    <div class="interacao d-flex">
        <!-- Formulário de adicionar itens -->
        <form action="../controller/comandas/controllerComandas.php" method="POST" class="d-flex">
            <input type="text" name="item" class="form-control" placeholder="Digite o nome ou ID do produto" required>
            <input type="number" name="quantidade" class="form-control" placeholder="Quantidade" value="1" min="1" required>
            <button type="submit" class="btn btn-outline-warning">Adicionar</button>
        </form>
        
        <!-- Botão emitir comanda -->
        <form action="../controller/comandas/emitirComandas.php" class="d-flex justify-content-end" id="form-emitir">
            <button class="btn btn-outline-warning">Emitir Comanda</button>
        </form>
    </div>
    <!-- Total da comanda -->
    <div class="totalComanda">
        <h4>Total: R$ <?= number_format($_SESSION["comanda_total"] ?? 0, 2, ",", ".") ?></h4>
    </div>
    <div class="w-100 mt-3"> 
        <table class="tabela table table-striped">
            <thead>
                <tr>
                    <th>Nome Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unit.</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_SESSION["comanda_itens"]) && count($_SESSION["comanda_itens"]) > 0): ?>
                    <?php foreach ($_SESSION["comanda_itens"] as $index => $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item["nome_item"]) ?></td>
                            <td><?= htmlspecialchars($item["quantidade"]) ?></td>
                            <td>R$ <?= number_format($item["val_unitario"], 2, ",", ".") ?></td>
                            <td>R$ <?= number_format($item["val_unitario"] * $item["quantidade"], 2, ",", ".") ?></td>
                            <td>
                                <div class="acoes">
                                    <!-- Botão para editar (se quiser implementar depois) -->
                                    <a href="#" class="editar">
                                        <i class="material-icons md-edit"></i>
                                    </a>
                                    <!-- Botão para remover -->
                                    <a href="../controller/comandas/controllerComandas.php?remover=<?= $index ?>" class="remover">
                                        <i class="material-icons md-delete"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum item na comanda</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</main>

<?= include "./partials/footer.html" ?>
</body>
</html>
