<?php
require_once __DIR__ . "/../controller/pdv/controllerPdv.php";
if (!isset($_SESSION['itens'])) {
    $_SESSION['itens'] = [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Vendas</title>
    <!-- link do Bootstrap -->
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/pdv.css">
    <!-- link do CSS -->
    <link rel="stylesheet" href="../css/padrao.css">
</head>

<body>

    <main class="main-pdv">

        <div class="adicionarItens">

            <div class="topoPag">
                <h1>Adicionar Produtos</h1>
            </div>

            <form action="../controller/pdv/adicionar.php" method="POST">
                <div class="pesquisarItens">

                    <input type="text" name="item" id="item" placeholder="Pesquisar Produto" class="form-control">
                    <input type="number" name="quantidade" id="quantidade" min="0" placeholder="Quantidade"
                        class="form-control">

                    <button type="submit" class="btn btn-outline-warning">Adicionar</button>

                </div>
            </form>

            <div class="itens">
                <table class="table">
                    <thead>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </thead>
                    <?php if (isset($_SESSION['itens']) && count($_SESSION['itens']) > 0): ?>
                        <?php foreach ($_SESSION['itens'] as $item): ?><tr>
                            <td><?= htmlspecialchars($item['nome_item']) ?></td>
                            <td><?=htmlspecialchars($item['quant']) ?></td>  
                            <td>R$ <?= number_format($item['val_unitario'], 2, ',', '.') ?></td>   
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum item no carrinho</p>
                    <?php endif; ?>

                    <td>
                        <div class="acoes">
                            <div class="editar">
                                <i class="material-icons md-edit"></i>
                            </div>
                            <div class="excluir">
                            <i class="material-icons md-delete"></i>
                            </div>
                        </div>
                    </td></tr> 
                </table>
            </div>

        </div>

        <div class="contabilizarVendas">

            <div class="topoPag-conta">
                <h2>Sistema de Vendas</h2>
            </div>

            <div class="infoCaixa">

                <div class="info">
                    <h4>Data e Hora: 13/05/2025 - 13:33</h4>
                    <h4>Atendente: Yan Carlos</h4>
                </div>


                <div class="logo">
                    <img src="../img/icon.png" alt="Mokele">
                </div>
            </div>

            <div class="finalizarVenda">
                <button class="btn btn-outline-danger">Cancelar</button>
                <button class="btn btn-outline-success">Confirmar</button>
            </div>
        </div>
    </main>

</body>

</html>