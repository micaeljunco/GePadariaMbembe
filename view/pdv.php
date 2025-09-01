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
                    <!-- <label for="item"><i class="material-icons md-barcode"></i></label> -->
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
                        <th>Valor Unitário</th>
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
                            <td>R$<span class="subtotal"> <?= number_format($item["val_unitario"]
,2,",",".",) ?></span></td>
                            <td>R$<span class="subtotal"> <?= number_format($item["val_unitario"] * $item["quantidade"],2,",",".",) ?></span></td>
                            <td>
                                <div class="acoes">
                                    <div class="editar">
                                        <i class="material-icons md-edit"></i>
                                    </div>
                                </td>
                            </tr>
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

            <div class="infoFinal">
                <p id="valorTotal">
                    <span class="currency">Total:</span>
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
                <button class="btn btn-outline-success"
                    onclick="document.getElementById('finalizarCompra').showModal()">Finalizar</button>
            </div>
        </div>
    </main>
    <dialog id="finalizarCompra" class="popupContainer">
        <div class="nomePopup">
            <h2>Finalizar Venda</h2>
            <i class="material-icons md-close" onclick="document.getElementById('finalizarCompra').close()"></i>
        </div>
        <div id="metodosPag">
            <div class="metodos" onclick="document.getElementById('metodoDinheiro').showModal(); document.getElementById('finalizarCompra').close()">
                <img src="../src/img/dinheiro.png" alt="" width="50px">
                <span>Dinheiro</span>
            </div>
            <div class="metodos" onclick="document.getElementById('metodoPIX').showModal(); document.getElementById('finalizarCompra').close()">
                <img src="../src/img/pix.png" alt="" width="50px">
                <span>PIX</span>
            </div>
            <div class="metodos" onclick="document.getElementById('').showModal(); document.getElementById('finalizarCompra').close()">
                <img src="../src/img/cartao.png" alt="" width="50px">
                <span>Cartão</span>
            </div>
            <div class="metodos" onclick="document.getElementById('').showModal(); document.getElementById('finalizarCompra').close()">
                <img src="../src/img/boleto.png" alt="" width="50px">
                <span>Boleto</span>
            </div>
        </div>

        <div class="infoFinal">
                <p id="valorTotal">
                    <span class="currency">Total:</span>
                    <span id="total">R$
                        <?= number_format($_SESSION["total"], 2, ",", ".") ?>
                    </span>
                </p>
                <p id="troco">
                    <span class="currency">Troco:</span>
                    <span id="total">R$
                        <?= number_format($_SESSION["total"], 2, ",", ".") ?>
                    </span>
                </p>
            </div>
    </dialog>

    <dialog id="metodoDinheiro" class="popupContainer">
        <div class="nomePopup">
            <h2>Método: Dinheiro</h2>
            <i class="material-icons md-close" onclick="document.getElementById('metodoDinheiro').close()"></i>
        </div>
        <form class="form-finalizarPag">
            <div class="botoes-compra">
                <button type="submit" class="btn btn-outline-success">Continuar</button>
                <button type="button" class="btn btn-outline-danger">Cancelar</button>
            </div>
        </form>
    </dialog>

    <dialog id="metodoPIX" class="popupContainer">
        <div class="nomePopup">
            <h2>Método: PIX</h2>
            <i class="material-icons md-close" onclick="document.getElementById('metodoPIX').close()"></i>
        </div>
        <form class="form-finalizarPag">
            <div class="botoes-compra">
            <button type="submit" class="btn btn-outline-success">Continuar</button>
            <button type="button" class="btn btn-outline-danger">Cancelar</button>
            </div>
        </form>
    </dialog>

    <script>
        function dataHora() {
            const agora = new Date();
            const ano = agora.getFullYear();
            const mes = String(agora.getMonth() + 1).padStart(2, '0');
            const dia = String(agora.getDate()).padStart(2, '0');

            document.getElementById('dataHoraP').textContent = `${dia}/${mes}/${ano}`;
        }
        setInterval(dataHora, 900);
        dataHora();
    </script>
    <?= include "./partials/footer.html" ?>

</body>

</html>