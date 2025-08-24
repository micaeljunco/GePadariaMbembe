<?php
require_once __DIR__ . "/../controller/itens/controllerItens.php";

$itens = consulta_itens();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário</title>
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.css">
</head>
<style>
input, label, select {
    display:block;
}
</style>
<body>
    <h2>Inventário</h2>
    <button type="button" class="btn btn-primary" onclick="document.getElementById('cadastroItens').showModal()">Cadastrar</button>
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
                </select>

                <label id="valUni">* Valor Unitário:</label>
                <input type="number" id="valUni" name="valUni" step="0.01" min="0" required>

                <button type="submit">Cadastrar</button>
            </form>
        </dialog>
    <hr>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Qtde. Mínima</th>
                <th>Qtde. em Estoque</th>
                <th>Categoria</th>
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
                        <td><?= htmlspecialchars($item["validade"]) ?></td>
                        <td><?= htmlspecialchars($item["id_fornecedor"]) ?></td>
                        <td>R$<?= htmlspecialchars(
                            $item["val_unitario"],
                        ) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td>Não foi possível buscar itens no estoque.<br>
                    <td>Detalhes:
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
</body>

</html>
