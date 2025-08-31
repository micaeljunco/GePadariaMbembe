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

require_once __DIR__ . "/../controller/pdv/controllerPdv.php";
if (!isset($_SESSION["itens"]) or isset($_POST["limpar"])) {
    $_SESSION["itens"] = [];
    $_SESSION["total"] = 0.0;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Vendas</title>
    <!-- link do Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- link do CSS -->
    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/pdv.css">

</head>

<body>
    <?= include "./partials/sidebar.html" ?>
    <main class="main-pdv">

        <div class="adicionarItens">

            <div class="topoPag">
                <h1>Adicionar Produtos</h1>
            </div>

            <form action="../controller/pdv/adicionar.php" method="POST" onsubmit="atualizarTotal()">
                <div class="pesquisarItens">

                    <input type="text" name="item" id="item" placeholder="Pesquisar Produto" class="form-control">
                    <input type="number" name="quantidade" id="quantidade" min="1" placeholder="Quantidade"
                        class="form-control">

                    <button type="submit" class="btn btn-outline-warning">Adicionar</button>

                </div>
            </form>

            <div id="container-table">
                <table class="table" id="tabela-itens">
                    <thead>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </thead>
                    <?php if (
                        isset($_SESSION["itens"]) &&
                        count($_SESSION["itens"]) > 0
                    ): ?>
                        <?php foreach (
                            $_SESSION["itens"]
                            as $index => $item
                        ): ?><tr>
                            <td><?= htmlspecialchars($item["nome_item"]) ?></td>
                            <td><?= htmlspecialchars(
                                $item["quantidade"],
                            ) ?></td>
                            <td>R$<span class="subtotal"> <?= number_format(
                                $item["val_unitario"] * $item["quantidade"],
                                2,
                                ",",
                                ".",
                            ) ?></span></td>
                            <td>
                                <div class="acoes">
                                    <div class="editar">
                                        <i class="material-icons md-edit"></i>
                                    </div>
                                    <div class="excluir">
                                    <a href="../controller/pdv/controllerPdv.php?remover=<?= $index ?>"><i class="material-icons md-delete"></i></a>
                                    </div>
                                </div>
                            </td></tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td colspan="4">Nenhum item no carrinho</td>
                    <?php endif; ?>

                </table>
            </div>
        </div>

        <div class="contabilizarVendas">

            <div class="topoPag-conta">
                <h2>Sistema de Vendas</h2>
            </div>

            <div class="infoCaixa">
                <h4 id="dataHoraP"></h4>
                <img src="../src/img/icon.png" class="logo" alt="Mokele">
            </div>

            <div id="infoFinal">
                <p id="valorTotal">
                    <span id="currency">Total:</span>
                    <span id="total">R$
                        <?= number_format($_SESSION["total"], 2, ",", ".") ?>
                    </span>
                </p>
            </div>

            <div id="finalizarVenda">
                <form action="pdv.php" method="post">
                    <input type="hidden" name="limpar">
                    <button type="submit" class="btn btn-outline-danger">Limpar</button>
                </form>
                <button class="btn btn-outline-success">Confirmar</button>
            </div>
        </div>
    </main>
    <script>
        function dataHora(){
            const agora = new Date();
            const ano = agora.getFullYear();
            const mes = String(agora.getMonth() + 1).padStart(2, '0');
            const dia = String(agora.getDate()).padStart(2, '0');
            const hora = String(agora.getHours()).padStart(2, '0');
            const min = String(agora.getMinutes()).padStart(2, '0');
            const sec = String(agora.getSeconds()).padStart(2, '0');

            document.getElementById('dataHoraP').textContent = `${hora}:${min}:${sec} ${dia}/${mes}/${ano}`;
        }
        setInterval(dataHora, 900);
        dataHora();
    </script>
    <?= include "./partials/footer.html" ?>

</body>

</html>
