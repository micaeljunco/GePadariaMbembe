<?php
//inclui o arquivo de controller dos fornecedores e incia a sessão
require_once __DIR__ . "/../controller/fornecedores/controllerFornecedores.php";
session_start();

//Verifica o acesso do usuario atraves das funções
require_once __DIR__ . "/../controller/permissions/permission.php"; //Chamada de arquivo com as funções
verificar_logado(); //Verifica se o usuario logou
verificar_acesso($_SESSION["id_cargo"]); //Verifica o nivel de acesso para liberar as paginas corretas

//Se o metodo for get(padrão) executara uma busca de todos os fornecedores, caso contrario buscara um em especifico
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $fornecedores = busca_fornecedores();
} else {
    $fornecedores = consulta_fornecedores();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores</title>
    <!-- Link do Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <!-- Link do CSS -->
    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/itens.css">

    <script src="../src/js/fornecedores.js"></script>
    <link rel="icon" type="image/png" href="../src/img/icon.png">
</head>

<body>
    <?= include "./partials/sidebar.php" ?>

    <main id="main-inventario">

        <div id="topo-pagina">
            <h1>Gestão de Fornecedores</h1>
        </div>

        <!-- Chama o popup de cadastro de fornecedores atraves de um dialog com js -->
        <div id="container-top">
            <div id="cadastro_relatorio">
                <button type="button" id="abrirCadastroFornecedores" class="btn btn-outline-warning"
                    onclick="document.getElementById('cadastroFornecedores').showModal()">Cadastrar Fornecedores</button>
            </div>
            <form method="get" action="fornecedores.php" id="form-busca-itens" class="busca">
                <input type="text" class="form-control" name="busca" placeholder="Pesquisar Fornecedores">
                <button type="submit" class="btn btn-outline-warning">Buscar</button>
            </form>
        </div>
        
        <!-- popup de cadastro de fornecedores -->
        <dialog id="cadastroFornecedores" class="popupContainer">
            <div class="nomePopup">
                <h2>Cadastro de Fornecedores</h2>
                <i class="material-icons md-close" onclick="document.getElementById('cadastroFornecedores').close()"></i>
            </div>
            <form action="../controller/fornecedores/cadastrarFornecedores.php" method="POST" class="w-100">
                <label for="nomeFornecedor" class="form-label">* Nome do Fornecedor:</label>
                <input type="text" class="form-control" id="nomeFornecedor" name="nomeFornecedor" maxlength="255" minlength="1" required>

                <label for="cnpjFornecedor" class="form-label">* CNPJ:</label>
                <input type="text" class="form-control" id="cnpjFornecedor" name="cnpjFornecedor" required maxlength="18"
                    pattern="^\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}$" title="Formato esperado: 00.000.000/0000-00">

                <label for="descFornecedor" class="form-label">Descrição:</label>
                <textarea class="form-control" name="descFornecedor" id="descFornecedor" required></textarea>

                <label for="telFornecedor" class="form-label">* Telefone:</label>
                <input type="text" class="form-control" name="telefone" id="telFornecedor" required maxlength="20"
                    pattern="^\(\d{2}\)\s?\d{4,5}-\d{4}$" title="Formato esperado: (xx) xxxx-yyyy ou (xx) xxxxx-yyyy">

                <button type="submit" class="btn btn-outline-warning">Cadastrar</button>
            </form>
        </dialog>

        <!-- Tabela de exibição dos fornecedores -->
        <div id="ctnr-tabela">
            <?php if (!empty($fornecedores)): ?>
                <table class="tabela">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Telefone</th>
                            <th>CNPJ</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Para cada fornecedor em $fornecedores, exibe os dados dos fornecedores -->
                        <?php foreach ($fornecedores as $fornecedor): ?>
                            <tr>
                                <td data-id-fornecedor="<?= $fornecedor["id_fornecedor"] ?>">
                                    <?= htmlspecialchars($fornecedor["id_fornecedor"]) ?>
                                </td>
                                <td><?= htmlspecialchars($fornecedor["nome_fornecedor"]) ?></td>
                                <td><?= htmlspecialchars($fornecedor["descricao"]) ?></td>
                                <td>(<?= htmlspecialchars($fornecedor["ddd"]) ?>) <?= htmlspecialchars($fornecedor["numero"]) ?></td>
                                <td><?= htmlspecialchars($fornecedor["cnpj"]) ?></td>
                                <td class="acoes">
                                    <form action="../controller/fornecedores/deletarFornecedores.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="deletar" value="<?= $fornecedor["id_fornecedor"] ?>">
                                        <button type="submit" class="botao-acoes">
                                            <i class="material-icons md-delete deletar"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="botao-acoes"
                                        onclick="editarFornecedor(this.parentElement.parentElement.parentElement.parentElement)">
                                        <i class="material-icons md-edit editar"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Caso nenhum fornecedore exista exibe essa mensagem -->
            <?php else: ?>
                <p>Nenhum Fornecedor encontrado.</p>
            <?php endif; ?>
        </div>
        
        <!-- Função de Editar fornecedores -->
        <dialog id="editarFornecedor" class="popupContainer">
            <div class="nomePopup">
                <h2>Editar Fornecedor</h2>
                <i class="material-icons md-close" onclick="document.getElementById('editarFornecedor').close()"></i>
            </div>
            <form action="../controller/fornecedores/editarFornecedor.php" method="POST" class="w-100">
                <input type="hidden" name="id_fornecedor" id="id_fornecedorEd">

                <label for="nomeFornecedorEd" class="form-label">* Nome do Fornecedor:</label>
                <input type="text" id="nomeFornecedorEd" name="nomeFornecedor" maxlength="255" minlength="1" class="form-control" required>

                <label for="cnpjFornecedorEd" class="form-label">* CNPJ:</label>
                <input type="text" id="cnpjFornecedorEd" name="cnpjFornecedor" maxlength="18" pattern="^\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}$" title="Formato esperado: 00.000.000/0000-00" class="form-control" required>

                <label for="descFornecedorEd" class="form-label">Descrição:</label>
                <textarea name="descFornecedor" id="descFornecedorEd" class="form-control" required></textarea>

                <label for="telFornecedorEd" class="form-label">* Telefone:</label>
                <input type="text" name="telefone" id="telFornecedorEd" maxlength="20" pattern="^\(\d{2}\)\s?\d{4,5}-\d{4}$" title="Formato esperado: (xx) xxxx-yyyy ou (xx) xxxxx-yyyy" class="form-control" required>

                <button type="submit" class="btn btn-outline-warning">Salvar</button>
            </form>
        </dialog>

    </main>

    <?= include "./partials/footer.html" ?>
</body>


</html>