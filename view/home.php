<?php
session_start();

require_once __DIR__ . "/../controller/permissions/permission.php";
verificar_logado();
require_once "../controller/principal/controllerHome.php";
// Chamadas às funções
$estoqueBaixo = aviso_estoque_critico();
$maisVendidos = mais_vendidos();
$faturDia = faturamento_dia();
$faturMes = faturamento_mes();
$ticketMedio = ticket_medio();
$horaPico = horario_pico();
$idCargo = $_SESSION["id_cargo"] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/home.css">
    <link rel="icon" type="image/png" href="../src/img/icon.png">
    <title>Home</title>
</head>

<body>
    <?= include "./partials/sidebar.php" ?>

    <main id="mainHome">
        <header id="headerHome">
            <h1> Bem-vindo,
                <span id="usuLogado">
                    <?php echo $_SESSION["nome"]; ?>
                </span>!
            </h1>
        </header>

        <section id="sysStatus">
            <h2>Status do Sistema</h2>
            <div id="ctnrStatus">

                <div id="statusFinanceiro">
                    <h3>Faturamento do dia</h3>
                    <p>
                        <?php if (is_array($faturDia)): ?>
                            R$ <?= number_format(
                                $faturDia[0]["faturamento"] ?? 0,
                                2,
                                ",",
                                ".",
                            ) ?>
                        <?php else: ?>
                            <?= $faturDia ?>
                        <?php endif; ?>
                    </p>
                </div>

                <div id="statusHoraPico">
                    <h3>Horário de Pico</h3>
                    <?php if (is_array($horaPico)): ?>
                        <p><?= $horaPico[0]["hora"] ?>h (<?= $horaPico[0][
    "qtd_vendas"
] ?> vendas)</p>
                    <?php else: ?>
                        <p><?= $horaPico ?></p>
                    <?php endif; ?>
                </div>

                <div id="statusTicket">
                    <h3>Ticket Médio</h3>
                    <p>
                        <?php if (is_array($ticketMedio)): ?>
                            R$ <?= number_format(
                                $ticketMedio[0]["ticket_medio"] ?? 0,
                                2,
                                ",",
                                ".",
                            ) ?>
                        <?php else: ?>
                            <?= $ticketMedio ?>
                        <?php endif; ?>
                    </p>
                </div>

                <div id="statusEstoque">
                    <h3>Alerta de Estoque</h3>
                    <?php if (gettype($estoqueBaixo) != "string"): ?>
                        <?php foreach ($estoqueBaixo as $key => $value): ?>
                            <p> <span class="itemBaixo"><?= htmlspecialchars(
                                $value["nome_item"],
                            ) ?></span> está com estoque
                                baixo </p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhuma informação sobre o estoque pode ser obtida.</p>
                    <?php endif; ?>
                </div>

                <div id="topProdutos">
                    <h3>Produtos Mais Vendidos do Mês</h3>
                    <?php if (is_array($maisVendidos)): ?>
                        <ol id="listTopProdutos">
                            <?php foreach ($maisVendidos as $produto): ?>
                                <li>
                                    <span class="itemVendido"><?= htmlspecialchars(
                                        $produto["nome_item"],
                                    ) ?></span> -
                                    <span class="uniItemVend">
                                        <?= $produto["unidade_medida"] === "UN"
                                            ? intval($produto["total_vendido"])
                                            : number_format(
                                                $produto["total_vendido"],
                                                2,
                                                ",",
                                                ".",
                                            ) ?>
                                    </span>
                                    <?= htmlspecialchars(
                                        $produto["unidade_medida"],
                                    ) ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php else: ?>
                        <p><?= htmlspecialchars($maisVendidos) ?></p>
                    <?php endif; ?>
                </div>


                <div id="statusFinanceiroMes">
                    <h3>Faturamento do mês</h3>
                    <p>
                        <?php if (is_array($faturMes)): ?>
                            R$ <?= number_format(
                                $faturMes[0]["faturamento"] ?? 0,
                                2,
                                ",",
                                ".",
                            ) ?>
                        <?php else: ?>
                            <?= $faturMes ?>
                        <?php endif; ?>
                    </p>
                </div>

            </div>
        </section>


        <section id="acsRapido">
            <h2>Acesso Rápido</h2>
            <div id="ctnrAcsRap">

                <?php if ($idCargo == 1 || $idCargo == 2): ?>
                    <div class="itemMenu" id="itemMenuPDV" data-link="./pdv.php">
                        <i class="material-icons md-storefront"></i>
                        <h3 class="tituloItemMenu">Ponto de Venda</h3>
                        <p class="descItemMenu">Sistema completo para realizar vendas e integrado a comandas</p>
                    </div>

                    <div class="itemMenu" id="itemMenuComa" data-link="./comandas.php">
                        <i class="material-icons md-confirmation_number"></i>
                        <h3 class="tituloItemMenu">Comandas</h3>
                        <p class="descItemMenu">Sistema de emissão de comandas</p>
                    </div>
                <?php endif; ?>

                <?php if ($idCargo == 1): ?>
                    <div class="itemMenu" id="itemMenuHist" data-link="./historicoVendas.php">
                        <i class="material-icons md-receipt"></i>
                        <h3 class="tituloItemMenu">Histórico de Vendas</h3>
                        <p class="descItemMenu">Acompanhe as últimas vendas da padaria</p>
                    </div>

                    <div class="itemMenu" id="itemMenuGEusu" data-link="./usuarios.php">
                        <i class="material-icons md-groups"></i>
                        <h3 class="tituloItemMenu">Gestão de Usuários</h3>
                        <p class="descItemMenu">Adicione, edite ou exclua usuários do sistema</p>
                    </div>
                <?php endif; ?>

                <?php if ($idCargo == 1 || $idCargo == 3): ?>
                    <div class="itemMenu" id="itemMenuEsto" data-link="./itens.php">
                        <i class="material-icons md-inventory_2"></i>
                        <h3 class="tituloItemMenu">Inventário</h3>
                        <p class="descItemMenu">Gerencie o estoque de produtos e insumos da panificadora</p>
                    </div>

                    <div class="itemMenu" id="itemMenuForn" data-link="./fornecedores.php">
                        <i class="material-icons md-local_shipping"></i>
                        <h3 class="tituloItemMenu">Fornecedores</h3>
                        <p class="descItemMenu">Adicione, edite ou exclua fornecedores</p>
                    </div>
                <?php endif; ?>

            </div>
        </section>


    </main>
    <?= include "./partials/footer.html" ?>
    <script>
        document.querySelectorAll('#acsRapido .itemMenu').forEach(div => {
            div.addEventListener('click', () => {
                const link = div.getAttribute('data-link')
                if (link) {
                    window.location.href = link
                }
            })
        })
    </script>


</body>

</html>
