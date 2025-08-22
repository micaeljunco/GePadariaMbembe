<?php
include "../PHP/consultaItens.php";
include "model_select_fornecedores.php";
$itens = (array) consulta_itens();
$fornecedores = consulta_fornecedores();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário</title>
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.css">
</head>

<body>
    <h2>Inventário</h2>
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
            <?php if ($itens): ?>
                <?php foreach ($itens as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['id_item']) ?></td>
                        <td title="<?= htmlspecialchars($item['nome_item']) ?>">
                            <?php
                            echo mb_strimwidth($item['nome_item'], 0, 18, '...')
                                ?>
                        </td>
                        <td><?= htmlspecialchars($item['quant_min']) ?></td>
                        <td><?= htmlspecialchars($item['quant']) ?></td>
                        <td><?= htmlspecialchars(ucfirst($item['categoria'])) ?></td>
                        <td><?= htmlspecialchars($item['validade']) ?></td>
                        <?php $fornecedor = item_fornecedor($item['id_item']); ?>
                        <td title="<?= $fornecedor['nome_fornecedor'] ?>"><?php
                        if ($fornecedor) {
                            echo mb_strimwidth($fornecedor['nome_fornecedor'], 0, 18, '...');
                        } else {
                            echo 'Nenhum';
                        }
                        ?></td>
                        <td>R$<?= htmlspecialchars($item['val_unitario']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <p>Não foi possível buscar itens no estoque.</p>
                    <p>Detalhes: <?php echo $item ?></p>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>