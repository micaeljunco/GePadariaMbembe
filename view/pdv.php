<?php
// Inicia a sessão para manipular variáveis globais do usuário
session_start();

//Verifica o acesso do usuario atraves das funções
require_once __DIR__ . "/../controller/permissions/permission.php"; //Chamada de arquivo com as funções
verificar_logado(); //Verifica se o usuario logou
verificar_acesso($_SESSION["id_cargo"]); //Verifica o nivel de acesso para liberar as paginas corretas

// Inclui o controlador do PDV (Ponto de Venda)
require_once __DIR__ . "/../controller/pdv/controllerPdv.php";

// Inicializa variáveis de sessão caso não existam
if (!isset($_SESSION["itens"])) {
    $_SESSION["itens"] = [];
    $_SESSION["metodos_pagamento"] = [];
    $_SESSION["total"] = 0.0;
}

// Se a venda está sendo finalizada, define o subtotal
if (isset($_GET["finalizar"])) {
    if (!isset($_SESSION["subtotal"])):
        $_SESSION["subtotal"] = $_SESSION["total"];
    endif;
}

// Inicializa o troco se não existir
if (!isset($_SESSION["troco"])) {
    $_SESSION["troco"] = 0.0;
}

// Inicializa métodos de pagamento se não existir
if (!isset($_SESSION["metodos_pagamento"])) {
    $_SESSION["metodos_pagamento"] = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Vendas</title>
    <!-- Importa o Bootstrap para estilização -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Importa os arquivos CSS personalizados -->
    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/pdv.css">
    <!-- Para favicon .png -->
    <link rel="icon" type="image/png" href="../src/img/icon.png">
</head>

<body>
    <!-- Inclui o menu lateral -->
    <?= include "./partials/sidebar.php" ?>
    <main class="main-pdv">

        <div class="adicionarItens">
            <div class="topoPag">
                <h1>Adicionar Produtos ao caixa</h1>
            </div>

            <!-- Formulário para adicionar itens ao carrinho -->
            <p id="dica">Use o prefixo "C" antes do ID de uma comanda no campo de busca para usá-la.</p>
            <form action="../controller/pdv/adicionar.php" method="POST" onsubmit="atualizarTotal()">
                <div class="pesquisarItens">
                    <!-- Campo de texto para digitar o NOME do produto -->
                    <!-- O value já vem preenchido com $_SESSION['editar']['nome'] caso o usuário esteja editando -->
                    <input type="text" name="item" id="item" value="<?php echo $_SESSION[
                        "editar"
                    ]["nome"] ??
                        ""; ?>" placeholder="Nome, ID ou comanda" class="form-control" required>
                    <!-- Campo numérico para informar a QUANTIDADE -->
                    <!-- O value também pode vir de $_SESSION['editar']['quantidade'], se estiver editando -->
                    <input type="number" name="quantidade" id="quantidade" min="0.001" step="0.001" value="<?php echo $_SESSION[
                        "editar"
                    ]["quantidade"] ??
                        ""; ?>" placeholder="Quantidade" class="form-control">
                    <!-- Botão que envia o formulário -->
                    <!-- Ao clicar, os dados (nome e quantidade) vão pro adicionar.php -->
                    <button type="submit" class="btn btn-outline-warning">Adicionar</button>
                </div>
            </form>

            <!-- Tabela de itens adicionados ao carrinho -->
            <div id="container-table">
                <table class="tabela" id="tabela-itens">
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
                                <td><?= htmlspecialchars(
                                    $item["nome_item"],
                                ) ?></td>
                                <td><?= htmlspecialchars(
                                    $item["quantidade"],
                                ) ?></td>
                                <td>R$<span class="subtotal"> <?= number_format(
                                    $item["val_unitario"],
                                    2,
                                    ",",
                                    ".",
                                ) ?></span></td>
                                <td>R$<span class="subtotal">
                                        <?= number_format(
                                            $item["val_unitario"] *
                                            $item["quantidade"],
                                            2,
                                            ",",
                                            ".",
                                        ) ?></span>
                                </td>
                                <td>
                                    <div class="acoes">
                                        <!-- Botão para editar o item -->
                                        <a href="../controller/pdv/controllerPdv.php?editar=<?php echo $index; ?>"
                                            class="editar">
                                            <i class="material-icons md-edit"></i>
                                        </a>
                                        <!-- Botão para remover o item -->
                                        <div class="remover">
                                            <a href="../controller/pdv/controllerPdv.php?remover=<?php echo $index; ?>"
                                                class="remover">
                                                <i class="material-icons md-delete"></i>
                                            </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Mensagem caso não haja itens no carrinho -->
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
                <img src="../src/img/icon.png" class="imgLogo" alt="Mokele">
            </div>

            <!-- Exibe o valor total da venda -->
            <div class="infoFinal">
                <p id="valorTotal">
                    <span class="currency">Total:</span>
                    <span id="total">R$
                        <?= number_format($_SESSION["total"], 2, ",", ".") ?>
                    </span>
                </p>
            </div>
            <div class="resumoVenda">
                <p><strong>Itens no carrinho:</strong>
                    <?php echo isset($_SESSION["itens"])
                        ? count($_SESSION["itens"])
                        : 0; ?>
                </p>
            </div>
            <div class="statusVenda">
                <p class="status">
                    <?php if (
                        isset($_SESSION["itens"]) &&
                        count($_SESSION["itens"]) > 0
                    ) {
                        echo 'Venda em andamento<span class="dots"></span>';
                    } else {
                        echo 'Aguardando itens<span class="dots"></span>';
                    } ?>
                </p>
            </div>


            <!-- Botões para cancelar ou finalizar a venda -->
            <div id="finalizarVenda">
                <!-- Formulário para cancelar a venda -->
                <form action="../controller/pdv/cancelarVenda.php" method="post"
                    onsubmit="return confirm('Você tem certeza de que quer cancelar essa venda?')">
                    <input type="hidden" name="limpar" value="1">
                    <button type="submit" class="btn btn-outline-danger">Cancelar</button>
                </form>
                <!-- Formulário para finalizar a venda -->
                <form action="./pdv.php">
                    <input type="hidden" name="finalizar" value="1">
                    <button class="btn btn-outline-success" type="submit" <?php if ($_SESSION["total"] == 0): ?> disabled
                        <?php endif; ?>>Finalizar</button>
                </form>
            </div>
        </div>
    </main>

    <!-- Modal para finalizar a compra e escolher métodos de pagamento -->
    <dialog id="finalizarCompra" class="popupContainer">
        <div class="nomePopup">
            <h2>Finalizar Venda</h2>
            <!--<i class="material-icons md-close" onclick="document.getElementById('finalizarCompra').close()"></i>-->
        </div>
        <h4 class="subtitulo-modal">Selecione um método: </h4>
        <div id="metodosPag">
            <div class="payment-card" onclick="selectMetodo('Dinheiro')">
                <img src="../src/img/dinheiro.png" />
                <div>Dinheiro</div>
            </div>
            <div class="payment-card" onclick="selectMetodo('Crédito')">
                <img src="../src/img/cartao.png" />
                <div>Crédito</div>
            </div>
            <div class="payment-card" onclick="selectMetodo('Débito')">
                <img src="../src/img/cartao.png" />
                <div>Débito</div>
            </div>
        </div>
        <div id="methodForm" style="display: none;">
            <!-- pagamento em dinheiro -->
            <div id="metodoDinheiro" class="metodos">
                <form class="form-finalizarPag" method="POST" action="../controller/pdv/metodosPag.php">
                    <input type="hidden" name="metodo" value="dinheiro">
                    <div class="campo-modal">
                        <label for="campo-dinheiro">Valor a pagar: </label>
                        <input type="number" name="dinheiro" class="form-control" id="campo-dinheiro" required
                            step="0.01">
                    </div>
                    <div class="botoes-compra">
                        <button type="reset" class="btn btn-outline-danger">Cancelar</button>
                        <button type="submit" class="btn btn-outline-primary">Continuar</button>
                    </div>
                </form>
            </div>

            <!-- pagamento com cartão de débito -->
            <div id="metodoCartDeb" class="metodos">
                <form class="form-finalizarPag" method="POST" action="../controller/pdv/metodosPag.php">
                    <input type="hidden" name="metodo" value="cartao-debito">
                    <div class="campo-modal">
                        <label for="campo-cartao">Valor a pagar:</label>
                        <input type="number" name="cartao" class="form-control" id="campo-cartao" required step="0.01">
                    </div>
                    <div class="campo-modal">
                        <label for="cartao_debito">Escolha o cartão de débito:</label>
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
                        <button type="reset" class="btn btn-outline-danger">Cancelar</button>
                        <button type="submit" class="btn btn-outline-primary">Continuar</button>
                    </div>
                </form>
            </div>

            <!-- pagamento com cartão de crédito -->
            <div id="metodoCartCred" class="metodos">
                <form class="form-finalizarPag" method="POST" action="../controller/pdv/metodosPag.php">
                    <input type="hidden" name="metodo" value="cartao-credito">
                    <div class="campo-modal">
                        <label for="campo-credito">Valor a pagar:</label>
                        <input type="number" name="cartao" class="form-control" id="campo-credito" required step="0.01">
                    </div>
                    <div class="campo-modal">
                        <label for="cartao_debito">Escolha o cartão de crédito</label>
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
                        <button type="reset" class="btn btn-outline-danger">Cancelar</button>
                        <button type="submit" class="btn btn-outline-primary">Continuar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal-footer">
            <div class="summary">
                Total: <span id="total">R$
                    <?= number_format($_SESSION["total"], 2, ",", ".") ?>
                </span><br />
                A pagar: <span id="subtotal">R$
                    <?= number_format($_SESSION["subtotal"], 2, ",", ".") ?>
                </span><br />
                Troco: <span id="troco">R$
                    <?= number_format($_SESSION["troco"], 2, ",", ".") ?>
                </span>
            </div>
            <form action="../controller/pdv/finalizarVenda.php" method="post" id="finalizarEmDefinitivo">
                <button type="submit" class="btn btn-success" <?php if ($_SESSION["subtotal"] > 0): ?> disabled <?php endif; ?>>Finalizar</button>
                <button type="button" class="btn btn-danger"
                    onclick="window.location.href='../controller/pdv/cancelarVenda.php'">Cancelar</button>
            </form>
        </div>
    </dialog>

    <script>
        function selectMetodo(method) {
            // Mostra a área geral do formulário
            document.getElementById("methodForm").style.display = "block";

            // Esconde todos os métodos
            document.getElementById("metodoDinheiro").style.display = "none";
            document.getElementById("metodoCartCred").style.display = "none";
            document.getElementById("metodoCartDeb").style.display = "none";

            // Remove .active de todos os cards
            document.querySelectorAll(".payment-card").forEach(card => {
                card.classList.remove("active");
            });

            // Exibe apenas o selecionado + adiciona destaque
            if (method === "Crédito") {
                document.getElementById("metodoCartCred").style.display = "block";
                document.querySelector(".payment-card:nth-child(2)").classList.add("active");
            } else if (method === "Débito") {
                document.getElementById("metodoCartDeb").style.display = "block";
                document.querySelector(".payment-card:nth-child(3)").classList.add("active");
            } else {
                document.getElementById("metodoDinheiro").style.display = "block";
                document.querySelector(".payment-card:nth-child(1)").classList.add("active");
            }
        }

        // Abre o modal automaticamente se estiver finalizando
        <?php if (isset($_GET["finalizar"])): ?>
            document.getElementById('finalizarCompra').showModal();
        <?php endif; ?>
    </script>

    <!-- Inclui o rodapé -->
    <?= include "./partials/footer.html" ?>

</body>

</html>