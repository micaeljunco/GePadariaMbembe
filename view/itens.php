<?php
session_start();

//Verifica o acesso do usuario atraves das funções
require_once __DIR__ . "/../controller/permissions/permission.php"; //Chamada de arquivo com as funções
verificar_logado(); //Verifica se o usuario logou
verificar_acesso($_SESSION["id_cargo"]); //Verifica o nivel de acesso para liberar as paginas corretas

//Inclue os controllers de fornecedores e de itens
require_once __DIR__ . "/../controller/itens/controllerItens.php";
require_once __DIR__ . "/../controller/fornecedores/controllerFornecedores.php";

//Declara $itens com a função consulta_itens
$itens = consulta_itens();

//Se o metodo do servidor for GET e busca existir e nao ser nula declara $itens com a função busca_item(busca apenas 1 item especifico)
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["busca"])) {
    $itens = busca_item($_GET["busca"]);
}
//Declara os fornecedores
$fornecedores = consulta_fornecedores();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/itens.css">
    <link rel="icon" type="image/png" href="../src/img/icon.png">
</head>

<body>
<?= include "./partials/sidebar.php" ?>

    <main id="main-inventario">

        <div id="topo-pagina">
            <h1>Inventário</h1>
        </div>

        <div id="container-top">
            <div id="cadastro_relatorio">
                <!-- <button type="button" class="btn btn-outline-warning">Gerar Relatório</button> -->
                <button type="button" id="abrirCadastroItens" class="btn btn-outline-warning"
                    onclick="document.getElementById('cadastroItens').showModal()">Cadastrar</button>
            </div>
            <form method="get" action="itens.php" id="form-busca-itens">
                <input type="text" class="form-control" name="busca" placeholder="Buscar Itens no inventario">
                <button type="submit" class="btn btn-outline-warning">Buscar</button>
            </form>
        </div>

        <!-- Popup de Cadastro de itens -->
        <dialog id="cadastroItens" class="popupContainer">
            <div class="nomePopup">
                <h2>Cadastrar Item</h2>
                <i class="material-icons md-close" onclick="document.getElementById('cadastroItens').close()"></i>
            </div>
            <form action="../controller/itens/cadastrarItens.php" method="POST">
                <label for="nomeItem" class="form-label">* Nome do Item:</label>
                <input type="text" id="nomeItem" class="form-control" name="nomeItem" maxlength="255" minlength="1"
                    required>

                <label for="cnpjItem" class="form-label">* Qtde. Mínima (para alertas):</label>
                <input type="number" id="quantMin" class="form-control" name="quantMin" step="0.001" min="0.001" required>

                <label for="quant" class="form-label">* Qtde. para o Inventário:</label>
                <input type="number" name="quant" id="quant" class="form-control" step="0.001" min="0.001" required>

                <label for="categoria" class="form-label">* Categoria:</label>
                <select id="categoria" class="form-control" name="categoria" required>
                    <option selected disabled>Selecione uma opção</option>
                    <option value="insumo">Insumo</option>
                    <option value="produto">Produto</option>
                </select>

                <label for="unidade_medida" class="form-label">* Unidade de Medida:</label>
                <select id="unidade_medida" class="form-select" name="unidade_medida" required>
                    <option selected disabled>Selecione uma opção</option>
                    <option value="UN">UN</option>
                    <option value="Kg">Kg</option>
                    <option value="g">g</option>
                    <option value="L">L</option>
                    <option value="ml">ml</option>
                </select>

                <label for="validade" class="form-label">* Validade:</label>
                <input type="date" name="validade" id="validade" class="form-control" required>

                <script>
                    // Obtem a data atual e define como valor minimo para o campo de validade;
                    const inputDate = document.getElementById('validade');
                    const today = new Date().toISOString().split('T')[0]; // "YYYY-MM-DD"
                    inputDate.min = today;
                </script>

                <label class="form-label" for="idFornecedor">Fornecedor:</label>
                <select id="idFornecedor" class="form-select" name="idFornecedor">
                    <option value="NULL" selected>Nenhum</option>
                    <!-- Para cada fornecedor em $fornecedores exibir o nome do fornecedor-->
                    <?php foreach ($fornecedores as $fornecedor): ?>
                        <option value="<?= $fornecedor[
                            "id_fornecedor"
                        ] ?>"><?= $fornecedor["nome_fornecedor"] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="valUni" class="form-label">* Valor Unitário:</label>
                <input type="number" id="valUni" class="form-control" name="valUni" step="0.01" min="0" required>

                <button type="submit" class="btn btn-outline-warning">Cadastrar</button>
            </form>
        </dialog>
        <div id="ctnr-tabela">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Qtde. Mínima</th>
                        <th>Qtde. em Estoque</th>
                        <th>Categoria</th>
                        <th>Medida</th>
                        <th>Validade (Y/M/D)</th>
                        <th>Fornecedor</th>
                        <th>Val. Unitário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Se $itens nao estiver vazio e o tipo for array, exibe todos os itens -->
                    <?php if (!empty($itens) && gettype($itens) == "array"): ?>
                        <?php foreach ($itens as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars(
                                    $item["id_item"],
                                ) ?></td>
                                <td title="<?= htmlspecialchars(
                                    $item["nome_item"],
                                ) ?>">
                                    <?php echo mb_strimwidth(
                                        $item["nome_item"],
                                        0,
                                        18,
                                        "...",
                                    ); ?>
                                </td>
                                <td><?= htmlspecialchars(
                                    $item["quant_min"],
                                ) ?></td>
                                <td><?= htmlspecialchars($item["quant"]) ?></td>
                                <td><?= htmlspecialchars(
                                    ucfirst($item["categoria"]),
                                ) ?></td>
                                <td><?= htmlspecialchars(
                                    ucfirst($item["unidade_medida"]),
                                ) ?></td>
                                <td><?= htmlspecialchars(
                                    $item["validade"],
                                ) ?></td>
                                <td data-id-fornecedor="<?= $item[
                                    "id_fornecedor"
                                ] ?>">
                                    <?= htmlspecialchars(
                                        fornecedor_item($item["id_fornecedor"]),
                                    ) ?>
                                </td>
                                <td><span>R$</span>
                                    <span><?= htmlspecialchars(
                                        $item["val_unitario"],
                                    ) ?></span>
                                </td>
                                <td class="acoes">
                                    <form action="../controller/itens/deletarItens.php" method="POST">
                                        <input type="hidden" name="deletar" value="<?= $item[
                                            "id_item"
                                        ] ?>">
                                        <button type="submit" class="botao-acoes">
                                            <i class="material-icons md-delete deletar"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="botao-acoes"
                                        onclick="editarItem(this.parentElement.parentElement)">
                                        <i class="material-icons md-edit editar"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php
                        // Caso contrario exibe essa mensagem
                        // Caso contrario exibe essa mensagem
                        else: ?>
                        <tr>
                            <td colspan="9">
                                <!-- se $itens for string exibe $itens -->
                                <?php if (is_string($itens)) {
                                    echo $itens;
                                } else {
                                    echo "Nenhum item encontrado.";
                                } ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Popup de editar item -->
        <dialog id="editarItem" class="popupContainer">
            <div class="nomePopup">
                <h2>Editar Item</h2>
                <i class="material-icons md-close" onclick="document.getElementById('cadastroItens').close()"></i>
            </div>
            <form action="../controller/itens/editarItens.php" method="POST">
                <input type="hidden" id="id_itemCampoEditar" name="id_item">

                <label for="nomeItem" class="form-label">* Nome do Item:</label>
                <input type="text" id="nomeItemEd" class="form-control" name="nomeItem" maxlength="255" minlength="1"
                    required>

                <label for="cnpjItem" class="form-label">* Qtde. Mínima (para alertas):</label>
                <input type="number" id="quantMinEd" class="form-control" name="quantMin" step="0.001" min="0.001" required>

                <label for="quant" class="form-label">* Qtde. em estoque:</label>
                <input type="number" name="quant" id="quantEd" class="form-control" step="0.001" min="0.001" required>

                <label for="categoriaEd" class="form-label">* Categoria:</label>
                <select id="categoriaEd" class="form-select" name="categoria" required>
                    <option selected disabled>Selecione uma opção</option>
                    <option value="insumo">Insumo</option>
                    <option value="produto">Produto</option>
                </select>

                <label for="unidade_medidaEd" class="form-label">* Unidade de Medida:</label>
                <select id="unidade_medidaEd" class="form-select" name="unidade_medida" required>
                    <option selected disabled>Selecione uma opção</option>
                    <option value="UN">UN</option>
                    <option value="Kg">Kg</option>
                    <option value="g">g</option>
                    <option value="L">L</option>
                    <option value="ml">ml</option>
                </select>

                <label for="validadeEd" class="form-label">* Validade:</label>
                <input type="date" name="validade" id="validadeEd" class="form-control" required>

                <script>
                    // Obtem a data atual e define como valor minimo para o campo de validade;
                    const inputDateEd = document.getElementById('validadeEd');
                    inputDateEd.min = today;
                </script>

                <label for="idFornecedorEd" class="form-label">Fornecedor:</label>
                <select id="idFornecedorEd" class="form-select" name="idFornecedor">
                    <option value="NULL" selected>Nenhum</option>
                    <!-- Para cada fornecedor em $fornecedores exibir o nome do fornecedor-->
                    <?php foreach ($fornecedores as $fornecedor): ?>
                        <option value="<?= $fornecedor[
                            "id_fornecedor"
                        ] ?>"><?= $fornecedor["nome_fornecedor"] ?></option>
                    <?php endforeach; ?>
                </select>

                <label id="valUniEd" class="form-label">* Valor Unitário:</label>
                <input type="number" id="valUniEd" class="form-control" name="valUni" step="0.01" min="0" required>

                <button type="submit" class="btn btn-outline-warning">Salvar</button>
            </form>
        </dialog>
        <script src="../src/js/itens.js"></script>
    </main>
    <?= include "./partials/footer.html" ?>
</body>

</html>
