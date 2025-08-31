<?php
require_once __DIR__ . "/../controller/fornecedores/controllerFornecedores.php";

session_start();

if (
    !isset($_SESSION["nome"]) ||
    !isset($_SESSION["id_usuario"]) ||
    !isset($_SESSION["id_cargo"])
) {
    // Melhor que usar JS, pois o usuario poderia desativá-lo.
    header("Location: ./");
    exit();
}

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
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <!-- Link do CSS -->
    <link rel="stylesheet" href="../css/padrao.css">
    <link rel="stylesheet" href="../css/ListaPadrao.css">

    <script src="../src/js/fornecedores.js"></script>
</head>

<body>
    <?= include "./partials/sidebar.html" ?>
    <dialog id="cadastroFornecedores" class="popup">
        <h2>Cadastro de Fornecedores</h2>
        <form action="../controller/fornecedores/cadastrarFornecedores.php" method="POST">
            <label for="nomeFornecedor">* Nome do Fornecedor:</label>
            <input type="text" id="nomeFornecedor" name="nomeFornecedor" maxlength="255" minlength="1" required>

            <label for="cnpjFornecedor">* CNPJ:</label>
            <input type="text" id="cnpjFornecedor" name="cnpjFornecedor" required maxlength="18"
                pattern="^\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}$" title="Formato esperado: 00.000.000/0000-00">

            <label for="descFornecedor">Descrição:</label>
            <textarea name="descFornecedor" id="descFornecedor" required></textarea>

            <label for="telFornecedor">* Telefone:</label>
            <input type="text" name="telefone" id="telFornecedor" required maxlength="20"
                pattern="^\(\d{2}\)\s?\d{4,5}-\d{4}$" title="Formato esperado: (xx) xxxx-yyyy ou (xx) xxxxx-yyyy">

            <button type="submit">Cadastrar</button>
        </form>
    </dialog>

    <main class="container">
        <div class="nomePag">
            <h1>Gestão de Fornecedores</h1>
        </div>
        <div class="tabela">
            <div class="interacao">

                <form action="fornecedores.php" method="GET" class="busca">
                    <div class="busca">
                        <input type="text" class="form-control" name="busca" placeholder="Pesquisar Fornecedores">
                        <button class="btn btn-outline-warning">Buscar</button>
                </form>
            </div>
            <div class="cadastro">
                <button class="btn btn-outline-warning"
                    onclick="document.getElementById('cadastroFornecedores').showModal()">Cadastrar
                    Fornecedores</button>
            </div>
        </div>
        <?php if (!empty($fornecedores)): ?>
            <table class="table">
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
                    <?php foreach ($fornecedores as $fornecedor): ?>
                        <tr>
                            <td data-id-fornecedor="<?= $fornecedor[
                                "id_fornecedor"
                            ] ?>">
                                <?= htmlspecialchars(
                                    $fornecedor["id_fornecedor"],
                                ) ?>
                            </td>
                            <td><?= htmlspecialchars(
                                $fornecedor["nome_fornecedor"],
                            ) ?></td>
                            <td><?= htmlspecialchars(
                                $fornecedor["descricao"],
                            ) ?></td>
                            <td>(<?= htmlspecialchars(
                                $fornecedor["ddd"],
                            ) ?>) <?= htmlspecialchars($fornecedor["numero"]) ?>
                            </td>
                            <td><?= htmlspecialchars(
                                $fornecedor["cnpj"],
                            ) ?></td>
                            <td>
                                <div class="acoes">
                                    <div class="editar">
                                        <i class="material-icons md-edit"></i>
                                    </div>
                                    <div class="excluir">
                                        <form action="../controller/fornecedores/deletarFornecedores.php" method="POST">
                                            <input type="hidden" name="deletar" value="<?= $fornecedor[
                                                "id_fornecedor"
                                            ] ?>">
                                            <button type="submit" class="btn btn-danger">Deletar</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary"
                                            onclick="editarFornecedor(this.parentElement.parentElement.parentElement.parentElement)">Editar</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum Fornecedor encontrado.</p>
        <?php endif; ?>

    </main>
    <?= include "./partials/footer.html" ?>
<dialog id="editarFornecedor" class="popup">
    <h2>Editar Fornecedor</h2>
    <form action="../controller/fornecedores/editarFornecedor.php" method="POST">
        <input type="hidden" name="id_fornecedor" id="id_fornecedorEd">

        <label for="nomeFornecedorEd">* Nome do Fornecedor:</label>
        <input type="text" id="nomeFornecedorEd" name="nomeFornecedor" maxlength="255" minlength="1" required>

        <label for="cnpjFornecedorEd">* CNPJ:</label>
        <input type="text" id="cnpjFornecedorEd" name="cnpjFornecedor" required maxlength="18"
            pattern="^\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}$" title="Formato esperado: 00.000.000/0000-00">


        <label for="descFornecedorEd">Descrição:</label>
        <textarea name="descFornecedor" id="descFornecedorEd" required></textarea>

        <label for="telFornecedorEd">* Telefone:</label>
        <input type="text" name="telefone" id="telFornecedorEd" required maxlength="20"
            pattern="^\(\d{2}\)\s?\d{4,5}-\d{4}$" title="Formato esperado: (xx) xxxx-yyyy ou (xx) xxxxx-yyyy">

        <button type="submit">Cadastrar</button>
    </form>
</dialog>
</body>

</html>
