<?php
include 'model_select_fornecedores.php';
$fornecedores = consulta_fornecedores();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Itens</title>
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.css">
    <style>
        label,
        input,
        textarea {
            display: flex;
            width: 100%;
        }
    </style>
</head>

<body>
    <button type="button" class="btn btn-primary"
        onclick="document.getElementById('cadastroItens').showModal()">Cadastrar Item</button>
    <dialog id="cadastroItens" class="popup">
        <h2>Cadastro de Itens</h2>
        <form action="model_insert_itens.php" method="POST">
            <label for="nomeItem">* Nome do Item:</label>
            <input type="text" id="nomeItem" name="nomeItem" maxlength="255" minlength="1" required>

            <label for="qtdeMinItem">* Quantia mínima (gera avisos):</label>
            <input type="number" name="qtdeMinItem" id="qtdeMinItem" min="0" max="2147483647" step="1">

            <label for="qtdeItem">* Quantia em estoque:</label>
            <input type="number" name="qtdeItem" id="qtdeItem" min="0" max="2147483647" step="1">

            <label for="catItem">* Categoria:</label>
            <select name="catItem" id="catItem" required>
                <option value="" selected disabled>Escolha uma opção</option>
                <option value="produto">Produto</option>
                <option value="insumo">Insumo</option>
            </select>

            <label for="valiItem">* Validade:</label>
            <input type="date" id="valiItem" name="valiItem" required>
            <script>
                // Obtem a data atual e define como valor minimo para o campo de validade;
                const inputDate = document.getElementById('valiItem');
                const today = new Date().toISOString().split('T')[0]; // "YYYY-MM-DD"
                inputDate.min = today;
            </script>

            <label for="valUniItem">* Valor Unitário (R$):</label>
            <input type="number" name="valUniItem" id="valUniItem" type="number" min="0.01" max="99999999.99"
                step="0.01" required>

            <label for="idFornItem">Fornecedor:</label>
            <select name="idFornItem" id="idFornItem" required>
                <option value="null" selected>Nenhum</option>
                <?php if (count($fornecedores) != 0): ?>
                    <?php foreach ($fornecedores as $fornecedor): ?>
                        <option value="<?= $fornecedor['id_fornecedor'] ?>"><?= $fornecedor['nome_fornecedor'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <button type="submit">Cadastrar</button>
        </form>
    </dialog>
</body>

</html>