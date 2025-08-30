<?php
session_start();

require_once __DIR__ . "/../controller/itens/controllerItens.php";
require_once __DIR__ . "/../controller/fornecedores/controllerFornecedores.php";

$itens = consulta_itens();

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["busca"])) {
    $itens = busca_item($_GET["busca"]);
}
$fornecedores = consulta_fornecedores();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário</title>
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.css">

    <link rel="stylesheet" href="../css/padrao.css">
    <link rel="stylesheet" href="../css/itens.css">
</head>
<body>
    <?= include "./partials/sidebar.html" ?>

    <main id="main-inventario">

        <div id="topo-pagina">
            <h1>Inventário</h1>
        </div>

        <div id="container-top">
            <div id="cadastro_relatorio">
                <button type="button" id="abrirCadastroItens" class="btn btn-outline-primary"
                onclick="document.getElementById('cadastroItens').showModal()">Cadastrar</button>
                <button type="button" class="btn btn-outline-secondary">Gerar Relatório</button>
            </div>
            <form method="get" action="itens.php" id="form-busca-itens">
                <input type="text" class="form-control" name="busca">
                <button type="submit" class="btn btn-secondary">Buscar</button>
            </form>
        </div>
    <dialog id="cadastroItens" class="popup">
        <h2>Cadastro de Itens</h2>
        <form action="../controller/itens/cadastrarItens.php" method="POST">
            <label for="nomeItem">* Nome do Item:</label>
            <input type="text" id="nomeItem" name="nomeItem" maxlength="255" minlength="1" required>

            <label for="cnpjItem">* Qtde. Mínima (para alertas):</label>
            <input type="number" id="quantMin" name="quantMin" step="1" min="0" required>

            <label for="quant">* Qtde. para o Inventário:</label>
            <input type="number" name="quant" id="quant" step="1" min="0" required>

            <label for="categoria">* Categoria:</label>
            <select id="categoria" name="categoria" required>
                <option selected disabled>Selecione uma opção</option>
                <option value="insumo">Insumo</option>
                <option value="produto">Produto</option>
            </select>

            <label for="unidade_medida">* Unidade de Medida:</label>
            <select id="unidade_medida" name="unidade_medida" required>
                <option selected disabled>Selecione uma opção</option>
                <option value="UN">UN</option>
                <option value="Kg">Kg</option>
                <option value="g">g</option>
                <option value="L">L</option>
                <option value="ml">ml</option>
            </select>

            <label for="validade">* Validade:</label>
            <input type="date" name="validade" id="validade" required>

            <script>
                // Obtem a data atual e define como valor minimo para o campo de validade;
                const inputDate = document.getElementById('validade');
                const today = new Date().toISOString().split('T')[0]; // "YYYY-MM-DD"
                inputDate.min = today;
            </script>

            <label>Fornecedor:</label>
            <select id="idFornecedor" name="idFornecedor">
                <option value="0" selected>Nenhum</option>
                <?php foreach ($fornecedores as $fornecedor): ?>
                    <option value="<?= $fornecedor[
                        "id_fornecedor"
                    ] ?>"><?= $fornecedor["nome_fornecedor"] ?></option>
                <?php endforeach; ?>
            </select>

            <label id="valUni">* Valor Unitário:</label>
            <input type="number" id="valUni" name="valUni" step="0.01" min="0" required>

            <button type="submit">Cadastrar</button>
        </form>
    </dialog>
    <hr>
    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Qtde. Mínima</th>
                <th>Qtde. em Estoque</th>
                <th>Categoria</th>
                <th>Medida</th>
                <th>Validade</th>
                <th>Fornecedor</th>
                <th>Val. Unitário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($itens) && gettype($itens) == "array"): ?>
                <?php foreach ($itens as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item["id_item"]) ?></td>
                        <td title="<?= htmlspecialchars($item["nome_item"]) ?>">
                            <?php echo mb_strimwidth(
                                $item["nome_item"],
                                0,
                                18,
                                "...",
                            ); ?>
                        </td>
                        <td><?= htmlspecialchars($item["quant_min"]) ?></td>
                        <td><?= htmlspecialchars($item["quant"]) ?></td>
                        <td><?= htmlspecialchars(
                            ucfirst($item["categoria"]),
                        ) ?></td>
                        <td><?= htmlspecialchars(
                            ucfirst($item["unidade_medida"]),
                        ) ?></td>
                        <td><?= htmlspecialchars($item["validade"]) ?></td>
                        <td data-id-fornecedor="<?= $item["id_fornecedor"] ?>">
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
            <?php else: ?>
                <tr>
                    <td>Não foi possível buscar itens no estoque.<br>
                    <td colspan="8">Detalhes:
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
    <hr>
    <dialog id="editarItem" class="popup">
        <h2>Editar Item</h2>
        <form action="../controller/itens/editarItens.php" method="POST">
            <input type="hidden" id="id_itemCampoEditar" name="id_item">
            <label for="nomeItem">* Nome do Item:</label>
            <input type="text" id="nomeItemEd" name="nomeItem" maxlength="255" minlength="1" required>

            <label for="cnpjItem">* Qtde. Mínima (para alertas):</label>
            <input type="number" id="quantMinEd" name="quantMin" step="1" min="0" required>

            <label for="quant">* Qtde. em estoque:</label>
            <input type="number" name="quant" id="quantEd" step="1" min="0" required>

            <label for="categoriaEd">* Categoria:</label>
            <select id="categoriaEd" name="categoria" required>
                <option selected disabled>Selecione uma opção</option>
                <option value="insumo">Insumo</option>
                <option value="produto">Produto</option>
            </select>

            <label for="unidade_medidaEd">* Unidade de Medida:</label>
            <select id="unidade_medidaEd" name="unidade_medida" required>
                <option selected disabled>Selecione uma opção</option>
                <option value="UN">UN</option>
                <option value="Kg">Kg</option>
                <option value="g">g</option>
                <option value="L">L</option>
                <option value="ml">ml</option>
            </select>

            <label for="validadeEd">* Validade:</label>
            <input type="date" name="validade" id="validadeEd" required>

            <script>
                // Obtem a data atual e define como valor minimo para o campo de validade;
                const inputDateEd = document.getElementById('validadeEd');
                inputDateEd.min = today;
            </script>

            <label>Fornecedor:</label>
            <select id="idFornecedorEd" name="idFornecedor">
                <option value="0" selected>Nenhum</option>
                <?php foreach ($fornecedores as $fornecedor): ?>
                    <option value="<?= $fornecedor[
                        "id_fornecedor"
                    ] ?>"><?= $fornecedor["nome_fornecedor"] ?></option>
                <?php endforeach; ?>
            </select>

            <label id="valUniEd">* Valor Unitário:</label>
            <input type="number" id="valUniEd" name="valUni" step="0.01" min="0" required>

            <button type="submit">Salvar</button>
        </form>
    </dialog>
    <script src="../src/js/itens.js"></script>
</main>
    <?= include "./partials/footer.html" ?>
</body>

</html>
