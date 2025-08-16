<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Vendas</title>
    <!-- link do Bootstrap -->
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <!-- link do CSS -->
     <link rel="stylesheet" href="../css/padrao.css">

     <style>
        /* Container Principal */
        main{
            display: flex;
            background-color: rgba(255, 255, 255, 0);
            justify-content: space-between;
            border: none;
        }

        /* Div adicionar itens(parte esquerda da pagina) */
        .adicionarItens{
            background-color: white;
            width: 120vh;
            height: 80vh;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .pesquisarItens{
            display: flex;
            height: 7%;
            width: 95%;
            margin-top: 20px;
            margin-bottom: 25px;
        }
        .pesquisarItens button{
            border-radius: 16px;
            width: 30%;
            margin-left: 50px;
        }
        .pesquisarItens input{
            width: 30%;
            margin-right: 20px;
        }
        .contabilizarVendas{
            background-color: white;
            width: 50vh;
            height: 80vh;
            border-radius: 16px;
        }
        .topoPag{
            background-color: var(--cor-primaria);
            width: 96%;
            text-align: center;
            color: white;
            padding: 10px;
            margin-top: 15px;
            border-radius: 16px 16px 0 0;
        }
        .acoes{
            display: flex;
        }
        .itens{
            width: 95%;
        }

        /* Div contabilizarVendas(parte direira da pagina) */

        .contabilizarVendas{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .contabilizarVendas img{
            width: 200px;
        }
        .infoCaixa{
            width: 100%;
            display: flex;
            height: 40%;
            align-items: center;
        }
        .infoCaixa h4+h4{
            margin-top: 40px;
        }
        .finalizarVenda{
            display: flex;
        }
        .finalizarVenda button{
            margin: 10px;
            border-radius: 16px;
        }
        .logo img{
            width: 40%;
            float: right;
            margin-right: 40px;
        }
        .info{
            width: 100%;
        }
        

     </style>
</head>
<body>

    <main class="container">
        
        <div class="adicionarItens">

            <div class="topoPag">
                <h1>Adicionar Produtos</h1>
            </div>


            <div class="pesquisarItens">

                <input type="text" placeholder="Pesquisar Produto" class="form-control">
                <input type="number" min="0" placeholder="Quantidade" class="form-control">

                <button class="btn btn-outline-warning">Adicionar</button>
            </div>

            <div class="itens">
                <table class="table">
                    <thead>
                        <th>Nome</th>
                        <th>quantidade</th>
                        <th>Preço</th>
                        <th>ações</th>
                    </thead>

                    <tbody>
                        <td>Pão de Queijo</td>
                        <td>16</td>
                        <td>19.90/KG</td>
                        <td>
                            <div class="acoes">
                                <div class="editar">
                                    <img src="../img/edit.png" alt="Editar">
                                </div>
                                <div class="excluir">
                                    <img src="../img/delete.png" alt="Excluir">
                                </div>
                            </div>
                            
                        </td>
                    </tbody>
                </table>
            </div>
            
        </div>

        <div class="contabilizarVendas">

            <div class="topoPag">
                <h2>Sistema de Vendas</h2>
            </div>

            <div class="infoCaixa">
                
                <div class="info">
                    <h4>Data e Hora: 13/05/2025 - 13:33</h4>
                    <h4>Atendente: Yan Carlos</h4>
                </div>

            </div>

            <div class="logo">
                    <img src="../img/icon.png" alt="Mokele">
                </div>

            <div class="finalizarVenda">
                <button class="btn btn-outline-danger">Cancelar</button>
                <button class="btn btn-outline-success">Confirmar</button>
            </div>
        </div>
    </main>
    
</body>
</html>