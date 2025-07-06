<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/padrao.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <title>Home</title>
</head>

<body>

    <main id="mainHome">
        <header id="headerHome">
            <h1> Bem-vindo,
                <span id="usuLogado">
                    Usuário
                </span>!
            </h1>
        </header>

        <section id="sysStatus">
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

        </section>

        <section id="acsRapido">
            <h2>Acesso Rápido</h2>
            <div id="ctnrAcsRap">
                <div class="itemMenu" id="itemMenuPDV">
                    <span class="material-symbols-outlined">
                        shopping_cart
                    </span>
                    <h3 class="tituloItemMenu">Painel de Vendas</h3>
                    <p class="descItemMenu">
                        Sistema completo para realizar vendas e integrado a comandas
                    </p>
                </div>

                <div class="itemMenu" id="itemMenuMoni">
                    <span class="material-symbols-outlined">
                        monitoring
                    </span>
                    <h3 class="tituloItemMenu">Monitoramento</h3>
                    <p class="descItemMenu">
                        Tenha uma visão sobre a padaria em forma de gráficos
                    </p>
                </div>

                <div class="itemMenu" id="itemMenuHist">
                    <span class="material-symbols-outlined">
                        history
                    </span>
                    <h3 class="tituloItemMenu">Histórico de Vendas</h3>
                    <p class="descItemMenu">
                        Acompanhe as últimas vendas da padaria
                    </p>
                </div>

                <div class="itemMenu" id="itemMenuEsto">
                    <span class="material-symbols-outlined">
                        inventory_2
                    </span>
                    <h3 class="tituloItemMenu">Estoque</h3>
                    <p class="descItemMenu">
                        Gerencie o estoque de produtos e insumos da padaria
                    </p>
                </div>

                <div class="itemMenu" id="itemMenuGEusu">
                    <span class="material-symbols-outlined">
                        groups
                    </span>
                    <h3 class="tituloItemMenu">Gerenciamento de Usuários</h3>
                    <p class="descItemMenu">
                        Adicione, edite ou desative usuários do sistema
                    </p>
                </div>

                <div class="itemMenu" id="itemMenuComa">
                    <span class="material-symbols-outlined">
                        confirmation_number
                    </span>
                    <h3 class="tituloItemMenu">Comandas</h3>
                    <p class="descItemMenu">
                        Sistema de emissão de comandas
                    </p>
                </div>

            </div>
        </section>

        <section id="diaInfo">

            <h2>Dia de Hoje</h2>

            <div id="ctnrDiaInfo">
                <div id="vendHoje">
                    <h3>Itens Vendidos Hoje</h3>
                    <canvas id="grafVendasHora"></canvas>
                    <p>
                        Total: <span id="totalVendasHoje">320</span>
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

        </section>

    </main>

    <footer id="footerPagina">
        <div id="usuFooter">
            <span class="material-symbols-outlined">
                account_circle
            </span>
            Usuário: <span id="usuLogado"> Usuário
            </span>
        </div>

        <span id="dataHora">
            21 jun 15:54
        </span>

        <span id="copy">
            Copyright: 2025-2025
        </span>
    </footer>
</body>

</html>