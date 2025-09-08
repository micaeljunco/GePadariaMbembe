<?php
session_start(); // inicia a sessão

// Verifica o acesso do usuário
require_once __DIR__ . "/../controller/permissions/permission.php";
verificar_logado();
verificar_acesso($_SESSION["id_cargo"]);

// Inclui o controller das comandas
require_once __DIR__ . "/../controller/comandas/controllerComandas.php";

// Inicializa variáveis de sessão caso não existam
if (!isset($_SESSION["comanda_itens"])) {
    $_SESSION["comanda_itens"] = [];
    $_SESSION["comanda_total"] = 0.0;
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
    <link rel="stylesheet" href="../src/css/itens.css">
    <link rel="stylesheet" href="../src/css/comandas.css">
    <link rel="icon" type="image/png" href="../src/img/icon.png">
</head>

<body>
<?= include "./partials/sidebar.php" ?>

<main id="main-comandas">

    <div id="topo-pagina">
        <h1>Emissão de Comandas</h1>
    </div>

    <div id="container-top">
        <!-- Form adicionar itens -->
        <form action="../controller/comandas/adicionar.php" method="POST" id="form-busca-itens">
            <input type="text" name="item" class="form-control" placeholder="Digite o nome ou ID do produto" required>
            <input type="number" name="quantidade" class="form-control" placeholder="Quantidade" min="0.001" step="0.001" required>
            <button type="submit" class="btn btn-outline-warning">Adicionar</button>
        </form>

        <!-- Total + ações -->
        <script>
            function cancelar()
            {
              if (confirm('Cancelar comanda?'))
                {
                  window.location.href='../controller/comandas/cancelar.php';
                }
            }
        </script>

        <div id="comandaFinalizar">
            <div id="totalComanda">
                <h5>Total: R$ <?= number_format(
                    $_SESSION["comanda_total"],
                    2,
                    ",",
                    ".",
                ) ?></h5>
            </div>
            <form action="../controller/comandas/finalizar.php" method="POST" onsubmit="return confirm('Finalizar comanda?')">
                <button type="submit" class="btn btn-outline-success">Finalizar</button>
            </form>
            <button type="button" class="btn btn-outline-danger" onclick="cancelar()">Cancelar</button>
        </div>
    </div>


    <div id="ctnr-tabela">
        <table class="tabela">
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
                <?php if (
                    !empty($_SESSION["comanda_itens"]) &&
                    is_array($_SESSION["comanda_itens"])
                ): ?>
                    <?php foreach (
                        $_SESSION["comanda_itens"]
                        as $index => $item
                    ): ?>
                        <tr>
                            <td title="<?= htmlspecialchars(
                                $item["nome_item"],
                            ) ?>">
                                <?= mb_strimwidth(
                                    htmlspecialchars($item["nome_item"]),
                                    0,
                                    18,
                                    "...",
                                ) ?>
                            </td>
                            <td><?= htmlspecialchars(
                                $item["quantidade"],
                            ) ?></td>
                            <td>R$ <?= number_format(
                                $item["val_unitario"],
                                2,
                                ",",
                                ".",
                            ) ?></td>
                            <td>R$ <?= number_format(
                                $item["val_unitario"] * $item["quantidade"],
                                2,
                                ",",
                                ".",
                            ) ?></td>
                            <td class="acoes">
                                <!--<button type="button" class="botao-acoes" onclick="editarItemComanda(<?= $index ?>)">
                                    <i class="material-icons md-edit editar"></i>
                                </button>-->
                                <form action="../controller/comandas/remover.php" method="GET" class="d-inline">
                                    <input type="hidden" name="remover" value="<?= $index ?>">
                                    <button type="submit" class="botao-acoes">
                                        <i class="material-icons md-delete deletar"></i>
                                    </button>
                                </form>
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

    <!-- Popup de edição de item -->
    <dialog id="editarItemComandaPopup" class="popupContainer">
        <div class="nomePopup">
            <h2>Editar Item</h2>
            <i class="material-icons md-close" onclick="document.getElementById('editarItemComandaPopup').close()"></i>
        </div>
        <form action="../controller/comandas/controllerComandas.php" method="POST">
            <input type="hidden" name="index" id="editarIndexComanda">
            <label for="nomeItemEdComanda" class="form-label">Nome do Item:</label>
            <input type="text" name="nomeItemEd" id="nomeItemEdComanda" class="form-control" required>
            <label for="quantidadeEdComanda" class="form-label">Quantidade:</label>
            <input type="number" name="quantidadeEd" id="quantidadeEdComanda" class="form-control" min="1" required>
            <button type="submit" class="btn btn-outline-warning">Salvar</button>
        </form>
    </dialog>

    <!-- Popup emitir comanda -->
    <dialog id="emitirComanda" class="popupContainer">
        <div class="nomePopup">
            <h2>Confirmar Emissão</h2>
            <i class="material-icons md-close" onclick="document.getElementById('emitirComanda').close()"></i>
        </div>
        <form action="../controller/comandas/emitirComandas.php" method="POST">
            <p>Deseja realmente emitir esta comanda?</p>
            <button type="submit" class="btn btn-outline-warning">Emitir</button>
        </form>
    </dialog>

</main>

<?php if (isset($_GET["resumo"]) and !empty($_GET["resumo"])): ?>
    <dialog class = "popupContainer" id="resumoComanda">
        <div class="nomePopup">
            <h2>Sucesso!</h2>
            <i class="material-icons md-close" onclick="window.location.href='comandas.php'"></i>
        </div>
        <div id="infoComanda">
            <h4>Código da Comanda: C<?= $_GET["resumo"] ?></h4>
            <p>Utilize este código no Ponto de Venda.</p>
        </div>
    </dialog>
    <script>
        document.getElementById('resumoComanda').showModal();
    </script>
<?php endif; ?>
<!-- Desnecessário -->
<!--<script>
    function editarItemComanda(index) {
        const item = ?// json_encode($itensComanda) [index];
        document.getElementById('editarIndexComanda').value = index;
        document.getElementById('nomeItemEdComanda').value = item.nome_item;
        document.getElementById('quantidadeEdComanda').value = item.quantidade;
        document.getElementById('editarItemComandaPopup').showModal();
    }
</script>-->

<?= include "./partials/footer.html" ?>
</body>
</html>
