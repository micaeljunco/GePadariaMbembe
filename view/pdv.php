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
if (!isset($_SESSION["itens"])) {
    $_SESSION["itens"] = [];
    $_SESSION['metodos_pagamento'] = [];
    $_SESSION["total"] = 0.0;
}

if (isset($_GET['finalizar'])) {
    if (!isset($_SESSION["subtotal"])):
        $_SESSION["subtotal"] = $_SESSION["total"];
    endif;
}

if (!isset($_SESSION["troco"])) {
    $_SESSION["troco"] = 0.0;
}

if (!isset($_SESSION['metodos_pagamento'])) {
    $_SESSION['metodos_pagamento'] = [];
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
                        ): ?>
                            <tr>
                                <td><?= htmlspecialchars($item["nome_item"]) ?></td>
                                <td><?= htmlspecialchars(
                                    $item["quantidade"],
                                ) ?></td>
                                <td>R$<span class="subtotal"> <?= number_format(
                                    $item["val_unitario"]
                                    ,
                                    2,
                                    ",",
                                    ".",
                                ) ?></span></td>
                                <td>R$<span class="subtotal">
                                        <?= number_format($item["val_unitario"] * $item["quantidade"], 2, ",", ".", ) ?></span>
                                </td>
                                <td>
                                    <div class="acoes">
                                        <div class="editar">
                                            <i class="material-icons md-edit"></i>
                                        </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td colspan="5">Nenhum item no carrinho</td>
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
                <form action="../controller/pdv/cancelarVenda.php" method="post" onsubmit="return confirm('Você tem certeza de que quer cancelar essa venda?')">
                    <input type="hidden" name="limpar" value="1">
                    <button type="submit" class="btn btn-outline-danger">Cancelar</button>
                </form>
                <form action="./pdv.php">
                    <input type="hidden" name="finalizar" value="1">
                    <button class="btn btn-outline-success" type="submit">Finalizar</button>
                </form>
            </div>
        </div>
    </main>

    <dialog id="finalizarCompra" class="popupContainer">
        <div class="nomePopup">
            <h2>Finalizar Venda</h2>
            <i class="material-icons md-close" onclick="document.getElementById('finalizarCompra').close()"></i>
        </div>
        <div id="metodosPag">
            <h4>Selecione um método: </h4>
            <div class="metodos"
                onclick="document.getElementById('metodoDinheiro').showModal(); document.getElementById('finalizarCompra').close()">
                <img src="../src/img/dinheiro.png" alt="" width="50px">
                <span>Dinheiro</span>
            </div>
            <div class="metodos"
                onclick="document.getElementById('metodoCartCred').showModal(); document.getElementById('finalizarCompra').close()">
                <img src="../src/img/cartao.png" alt="" width="50px">
                <span>Cartão de Crétido</span>
            </div>
            <div class="metodos"
                onclick="document.getElementById('metodoCartDeb').showModal(); document.getElementById('finalizarCompra').close()">
                <img src="../src/img/cartao.png" alt="" width="50px">
                <span>Cartão de Débito</span>
            </div>
        </div>
        <div class="infoFinal">
            <p id="valorTotal">
                <span class="currency">A pagar:</span>
                <span id="subtotal">R$
                    <?= number_format($_SESSION["subtotal"], 2, ",", ".") ?>
                </span>
                <span class="currency">Troco:</span>
                <span id="troco">R$
                    <?= number_format($_SESSION["troco"], 2, ",", ".") ?>
                </span>
            </p>
        </div>
        <h4>Métodos de Pagamento Selecionados:</h4>
        <div id="metodosSelecionados">
            <?php if (!empty($_SESSION['metodos_pagamento'])): ?>
                <ul>
                    <?php foreach ($_SESSION['metodos_pagamento'] as $p): ?>
                        <li>
                            <?= htmlspecialchars($p['metodo']) ?> - Valor: R$
                            <?= number_format($p['valor'], 2, ',', '.') ?>
                            <?php if (!empty($p['cartao'])): ?>
                                - Cartão: <?= htmlspecialchars($p['cartao']) ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Nenhum método de pagamento usado até então.</p>
            <?php endif; ?>
        </div>

        <div class="infoFinal">
            <form action="../controller/pdv/finalizarVenda.php" method="post" id="finalizarEmDefinitivo">
                <button type="submit" class="btn btn-success">Finalizar</button>
            </form>
        </div>
    </dialog>

    <dialog id="metodoDinheiro" class="popupContainer">
        <div class="nomePopup">
            <h2>Método: Dinheiro</h2>
        </div>
        <form class="form-finalizarPag" method="POST" action="../controller/pdv/metodosPag.php">
            <input type="hidden" name="metodo" value="dinheiro">
            <h2>Valor a pagar</h2>
            <div class="campo-modal">
                <label for="campo-dinheiro">R$: </label>
                <input type="number" name="dinheiro" class="form-control" id="campo-dinheiro" required step="0.01">
            </div>
            <div class="botoes-compra">
                <button type="button" class="btn btn-outline-danger"
                    onclick="document.getElementById('metodoDinheiro').close(); document.getElementById('finalizarCompra').showModal()">Cancelar</button>
                <button type="submit" class="btn btn-outline-success">Continuar</button>
            </div>
        </form>
    </dialog>

    <dialog id="metodoCartDeb" class="popupContainer metodo-cartao">
        <div class="nomePopup">
            <h2>Método: Cartão de Débito</h2>
        </div>

        <form class="form-finalizarPag" method="POST" action="../controller/pdv/metodosPag.php">
            <input type="hidden" name="metodo" value="cartao-debito">
            <h4>Valor a pagar</h4>
            <div class="campo-modal">
                <label for="campo-dinheiro">R$: </label>
                <input type="number" name="cartao" class="form-control" id="campo-dinheiro" required step="0.01">
            </div>
            <hr>
            <h4>Escolha o cartão de débito</h4>
            <div class="campo-modal">
                <label for="cartao_debito">Cartão:</label>
                <select name="cartao_debito" id="cartao_debito" class="form-select" required>
                    <option value="" selected disabled>Selecione</option>
                    <option value="visa_debito">Visa</option>
                    <option value="mastercard_debito">Mastercard</option>
                    <option value="elo_debito">Elo</option>
                    <option value="maestro_debito">Maestro</option>
                    <option value="banricompras_debito">Banricompras</option>
                </select>
            </div>

            <div class="botoes-compra">
                <button type="button" class="btn btn-outline-danger"
                    onclick="document.getElementById('metodoCartDeb').close(); document.getElementById('finalizarCompra').showModal()">Cancelar</button>
                <button type="submit" class="btn btn-outline-success">Continuar</button>
            </div>
        </form>
    </dialog>

    <dialog id="metodoCartCred" class="popupContainer metodo-cartao">
        <div class="nomePopup">
            <h2>Método: Cartão de Crédito</h2>
        </div>
        <form class="form-finalizarPag" method="POST" action="../controller/pdv/metodosPag.php">
            <input type="hidden" name="metodo" value="cartao-credito">
            <h4>Valor a pagar</h4>
            <div class="campo-modal">
                <label for="campo-dinheiro">R$: </label>
                <input type="number" name="cartao" class="form-control" id="campo-dinheiro" required step="0.01">
            </div>
            <hr>
            <h4>Escolha o cartão de crédito</h4>
            <div class="campo-modal">
                <label for="cartao_debito">Cartão:</label>
                <select name="cartao_credito" id="cartao_credito" class="form-select" required>
                    <option value="" selected disabled>Selecione</option>
                    <option value="visa_credito">Visa</option>
                    <option value="mastercard_credito">Mastercard</option>
                    <option value="elo_credito">Elo</option>
                    <option value="amex_credito">American Express</option>
                    <option value="hipercard_credito">Hipercard</option>
                </select>
            </div>

            <div class="botoes-compra">
                <button type="button" class="btn btn-outline-danger"
                    onclick="document.getElementById('metodoCartCred').close(); document.getElementById('finalizarCompra').showModal()">Cancelar</button>
                <button type="submit" class="btn btn-outline-success">Continuar</button>
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

    <?php if (isset($_GET["finalizar"])) : ?>
    <script>
        document.getElementById('finalizarCompra').showModal();
    </script>
    <?php endif; ?>

</body>

</html>