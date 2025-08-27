<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Vendas</title>
    <!-- link do Bootstrap -->
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/pdv.css">
    <!-- link do CSS -->
     <link rel="stylesheet" href="../css/padrao.css">
</head>
<body>

    <main class="main-pdv">
        
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
                
            <div class="topoPag-conta">
                <h2>Sistema de Vendas</h2>
            </div>

            <div class="infoCaixa">
                
                <div class="info">
                    <h4>Data e Hora: 13/05/2025 - 13:33</h4>
                    <h4>Atendente: Yan Carlos</h4>
                </div>

                
                <div class="logo">
                    <img src="../img/icon.png" alt="Mokele">
                </div>
            </div>

            <div class="finalizarVenda">
                <button class="btn btn-outline-danger">Cancelar</button>
                <button class="btn btn-outline-success">Confirmar</button>
            </div>
        </div>
    </main>
    
</body>
</html>