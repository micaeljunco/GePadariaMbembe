<?php
session_start();

require_once __DIR__ . "/../controller/permissions/permission.php";
verificar_logado();
verificar_acesso($_SESSION["id_cargo"]);

require_once "../controller/vendas/controllerVendas.php";

$vendas = consulta_vendas();

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["busca"])) {
    $vendas = busca_venda($_GET["busca"]);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Vendas</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/vendas.css">
</head>

<body>
<?= include "./partials/sidebar.php" ?>

    <main id="main-vendas">

        <div id="topo-pagina">
            <h1>Histórico de Vendas</h1>
        </div>

        <div id="container-top">
            <!--<div id="cadastro_relatorio">
                <button type="button" class="btn btn-outline-warning">Gerar Relatório</button>
                <button type="button" id="abrirCadastroItens" class="btn btn-outline-warning"
                    onclick="document.getElementById('cadastroItens').showModal()">Cadastrar</button>
            </div>-->
            <form method="get" action="historicoVendas.php" id="form-busca-vendas">
                <input type="text" class="form-control" name="busca" placeholder="Buscar vendas no histórico por ID ou vendedor">
                <button type="submit" class="btn btn-outline-warning">Buscar</button>
            </form>
        </div>

        <div id="ctnr-tabela">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vendedor</th>
                        <th>Valor Total</th>
                        <th>Data-Hora</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (
                        !empty($vendas) &&
                        gettype($vendas) == "array"
                    ): ?>
                        <?php foreach ($vendas as $venda): ?>
                        <tr>
                            <td><?= htmlspecialchars($venda["id_venda"]) ?></td>
                            <td><?= htmlspecialchars($venda["vendedor"]) ?></td>
                            <td><?= htmlspecialchars(
                                $venda["valor_total"],
                            ) ?></td>
                            <td><?= htmlspecialchars(
                                $venda["data_hora"],
                            ) ?></td>
                            <td>
                                <i class="material-icons md-open_in_full"
                                    onclick="window.location.href='historicoVendas.php?exibir=<?= htmlspecialchars(
                                        $venda["id_venda"]
                                    ) ?>'"></i>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">
                                <?php if (is_string($vendas)) {
                                    echo $vendas;
                                } else {
                                    echo "Nenhuma venda encontrada.";
                                } ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php if (isset($_GET["exibir"])):

        $id_venda = (int) $_GET["exibir"];
        $venda_detalhes = detalhes_venda($id_venda);
        $venda_metodos = metodos_venda($id_venda);
        ?>
    <dialog id="exibirDetalhes" class="popupContainer">
        <div class="nomePopup">
                <h2>Detalhes da Venda #<?= htmlspecialchars($id_venda) ?></h2>
                <i class="material-icons md-close"
                   onclick="window.location.href='historicoVendas.php'"></i>
            </div>

            <div id="ctnrDetalhes">
                <!-- Itens da venda -->
                <h3>Itens</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantidade</th>
                            <th>Unidade</th>
                            <th>Valor Unitário</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($venda_detalhes as $det): ?>
                        <tr>
                            <td><?= htmlspecialchars($det["nome_item"]) ?></td>
                            <td><?= htmlspecialchars($det["quantidade"]) ?></td>
                            <td><?= htmlspecialchars(
                                $det["unidade_medida"],
                            ) ?></td>
                            <td>R$ <?= number_format(
                                $det["val_unitario"],
                                2,
                                ",",
                                ".",
                            ) ?></td>
                            <td>R$ <?= number_format(
                                $det["subtotal"],
                                2,
                                ",",
                                ".",
                            ) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Métodos de pagamento -->
                <h3>Métodos de Pagamento</h3>
                <ul>
                    <?php foreach ($venda_metodos as $m): ?>
                        <li>
                            <?= htmlspecialchars($m["metodo"]) ?>:
                            R$ <?= number_format(
                                $m["valor_pago"],
                                2,
                                ",",
                                ".",
                            ) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
    </dialog>
    <script>
    document.getElementById('exibirDetalhes').showModal();
    </script>

    <?php
    endif; ?>
    <?= include "./partials/footer.html" ?>
</body>

</html>
