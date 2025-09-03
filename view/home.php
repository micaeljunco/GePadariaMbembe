<?php
session_start();

require_once __DIR__ ."/../controller/permissions/permission.php";
verificar_logado();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/home.css">
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

        <!--<section id="sysStatus">
            <h2>Status do Sistema</h2>
            <div id="ctnrStatus">

                <div id="statusPDV">
                    <h3>PDVs</h3>
                    <p>
                        <span class="idPDV">0-0001</span>:
                        <span class="statusAtivo">Ativo</span> (Última atividade:
                        <span class="atvPDV">17:05</span>)
                    </p>
                </div>

                <div id="statusComandas">
                    <h3>Comandas</h3>
                    <p>
                        Comandas abertas: <span id="aberComandas">3</span> <br>
                        Comandas encerradas hoje: <span id="enceComandas">54</span>
                    </p>
                </div>

                <div id="statusEstoque">
                    <h3>Alerta de Estoque</h3>
                    <p>
                        <span id="itemBaixo">Farinha</span> com estoque baixo
                    </p>
                    <p>
                        <span id="itemBaixo">Ovos</span> com estoque baixo
                    </p>
                    <p>
                        <span id="itemBaixo">Fermento</span> com estoque baixo
                    </p>
                </div>

            </div>

            </section>-->

        <section id="acsRapido">
            <h2>Acesso Rápido</h2>
            <div id="ctnrAcsRap">
                <div class="itemMenu" id="itemMenuPDV">
                    <i class="material-icons md-storefront">
                    </i>
                    <h3 class="tituloItemMenu">Ponto de Venda</h3>
                    <p class="descItemMenu">
                        Sistema completo para realizar vendas e integrado a comandas
                    </p>
                </div>

                <!--<div class="itemMenu" id="itemMenuMoni">
                    <i class="material-icons md-monitoring">
                    </i>
                    <h3 class="tituloItemMenu">Monitoramento</h3>
                    <p class="descItemMenu">
                        Tenha uma visão sobre a padaria em forma de gráficos
                    </p>
                </div>-->

                <div class="itemMenu" id="itemMenuHist">
                    <i class="material-icons md-receipt">
                    </i>
                    <h3 class="tituloItemMenu">Histórico de Vendas</h3>
                    <p class="descItemMenu">
                        Acompanhe as últimas vendas da padaria
                    </p>
                </div>

                <div class="itemMenu" id="itemMenuEsto">
                    <i class="material-icons md-inventory_2"></i>
                    <h3 class="tituloItemMenu">Inventário</h3>
                    <p class="descItemMenu">
                        Gerencie o estoque de produtos e insumos da panificadora
                    </p>
                </div>

                <div class="itemMenu" id="itemMenuGEusu">
                    <i class="material-icons md-local_shipping"></i>
                    <h3 class="tituloItemMenu">Fornecedores</h3>
                    <p class="descItemMenu">
                        Adicione, edite ou delete usuários do sistema
                    </p>
                </div>

                <div class="itemMenu" id="itemMenuForn">
                    <i class="material-icons md-groups"></i>
                    <h3 class="tituloItemMenu">Gestão de Usuários</h3>
                    <p class="descItemMenu">
                        Adicione, edite ou delete fornecedores
                    </p>
                </div>

                <div class="itemMenu" id="itemMenuComa">
                    <i class="material-icons md-confirmation_number">
                    </i>
                    <h3 class="tituloItemMenu">Comandas</h3>
                    <p class="descItemMenu">
                        Sistema de emissão de comandas
                    </p>
                </div>

            </div>
        </section>

        <!-- <section id="diaInfo">

            <h2>Dia de Hoje</h2>

            <div id="ctnrDiaInfo">
                <div id="vendHoje">
                    <h3>Itens Vendidos Hoje</h3>
                    <canvas id="grafVendasHora"></canvas>
                    <p>
                        Total: <span id="totalVendasHoje">320</i
                    </p>
                </div>

                <div id="topProdutos">
                    <h3>Produtos Mais Vendidos Hoje</h3>
                    <ol id="listTopProdutos">
                        <li>
                            <span id="itemVendido">Pão Francês
                            </span> - <span id="uniItemVend"> 104
                            </span> unidades
                        </li>

                        <li>
                            <span id="itemVendido">Croissant
                            </span> - <span id="uniItemVend"> 42
                            </span> unidades
                        </li>

                        <li>
                            <span id="itemVendido">Cuca
                            </span> - <span id="uniItemVend"> 26
                            </span> unidades
                        </li>

                        <li>
                            <span id="itemVendido">Café
                            </span> - <span id="uniItemVend"> 22
                            </span> unidades
                        </li>

                        <li>
                            <span id="itemVendido">Sonho
                            </span> - <span id="uniItemVend"> 16
                            </span> unidades
                        </li>

                    </ol>
                </div>

                <div id="movFaixaHora">
                    <h3>Movimentação por Faixa de Horário</h3>

                    <canvas id="grafMovFaixaHora"></canvas>

                    <p>
                        Pico: <span id="horaPico">12h-14h</span>
                    </p>
                </div>

            </div>

        </section>-->

    </main>
    <?= include "./partials/footer.html" ?>
    <script>
    const divs = [...document.querySelectorAll('#acsRapido .itemMenu')]

    // Coloque os links na mesma ordem das divs
    const links = [
      "./pdv.php",          // Ponto de Venda
      "./historicoVendas.php",  // Histórico de Vendas
      "./itens.php",        // Inventário
      "./fornecedores.php", // Fornecedores
      "./usuarios.php",    // Gestão de Usuários
      "./comandas.php"      // Comandas
    ]

    divs.forEach((div, index) => {
      div.addEventListener('click', () => {
        window.location.href = links[index]
      })
    })
    </script>

</body>

</html>
