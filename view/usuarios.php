<?php
session_start();

//Verifica o acesso do usuario atraves das funções
require_once __DIR__ . "/../controller/permissions/permission.php"; //Chamada de arquivo com as funções
verificar_logado(); //Verifica se o usuario logou
verificar_acesso($_SESSION["id_cargo"]); //Verifica o nivel de acesso para liberar as paginas corretas

//Inclue o controller de usuario
require_once __DIR__ . "/../controller/usuarios/controllerUsuario.php";

//Declara as variaves com as funções do controller
$usuarios = pesquisar_usuario();
$cargos = buscar_cargos();

//Cargos mapa para exibir o cargo do usuario
$cargosMapa = [
    1 => "Administrador",
    2 => "Atendente",
    3 => "Controlador de Estoque",
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/itens.css">
    <link rel="icon" type="image/png" href="../src/img/icon.png">
    
</head>

<body>
<?= include "./partials/sidebar.php" ?>

<main id="main-inventario">

    <div id="topo-pagina">
        <h1>Gestão de Usuários</h1>
    </div>

    <div id="container-top">
        <div id="cadastro_relatorio">
            <button type="button" class="btn btn-outline-warning" onclick="document.getElementById('criarPopup').showModal()">Cadastrar Usuários</button>
        </div>

        <form action="usuarios.php" method="POST" id="form-busca-itens" class="busca">
            <input type="text" name="busca" class="form-control" placeholder="Pesquisar Usuário">
            <button class="btn btn-outline-warning" type="submit">Buscar</button>
        </form>
    </div>

    <!-- Dialog de Cadastrar Usuários -->
    <dialog class="popupContainer" id="criarPopup">
        <div class="nomePopup">
            <h2>Cadastro de Usuários</h2>
            <i class="material-icons md-close" onclick="document.getElementById('criarPopup').close()"></i>
        </div>
        <form action="../controller/usuarios/criarUsuario.php" method="POST" class="w-100">
            <input type="text" name="nome" placeholder="Nome" class="form-control" required>
            <input type="text" name="senha" placeholder="Senha" class="form-control" required>
            <input type="email" name="email" placeholder="Email" class="form-control" required>
            <input type="text" name="cpf" placeholder="CPF" class="form-control" required>

            <select name="cargo" id="cargo" class="form-select" required>
                <!-- para cada cargo em $cargos exibe o nome do cargo -->
                <?php foreach ($cargos as $cargo): ?>
                    <option value="<?= $cargo["id_cargo"] ?>"><?= $cargo["nome_cargo"] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn btn-outline-warning">Salvar</button>
        </form>
    </dialog>

    <div id="ctnr-tabela">
        <!-- se $usuarios estiver vazio exibirá essa mensagem -->
        <?php if (!$usuarios): ?>
            <p>Nenhum usuário encontrado!</p>
        <?php else: ?>
            <!-- caso existir algo em $usuarios exibira os dados dos usuarios -->
            <table class="tabela">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cargo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Para cada usuario em $usuarios exibe os dados dos usuarios -->
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario["id_usuario"] ?></td>
                            <td><?= $usuario["nome_usuario"] ?></td>
                            <td><?= $usuario["email"] ?></td>
                            <td><?= $cargosMapa[$usuario["id_cargo"]] ?></td>
                            <td class="acoes">
                                <!-- Botão Editar -->
                                <button type="button" class="botao-acoes" onclick="document.getElementById('editarPopup<?= $usuario['id_usuario'] ?>').showModal()">
                                    <i class="material-icons md-edit editar"></i>
                                </button>

                                <!-- Dialog Editar Usuário -->
                                <dialog class="popupContainer" id="editarPopup<?= $usuario['id_usuario'] ?>">
                                    <div class="nomePopup">
                                        <h2>Editar Usuário</h2>
                                        <i class="material-icons md-close" onclick="document.getElementById('editarPopup<?= $usuario['id_usuario'] ?>').close()"></i>
                                    </div>
                                    <form action="../controller/usuarios/editarUsuario.php" method="POST" class="w-100" style="padding:20px;">
                                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">

                                        <input type="text" name="nome" placeholder="Nome" class="form-control" value="<?= htmlspecialchars($usuario['nome_usuario']) ?>" required>
                                        <input type="text" name="email" placeholder="Email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>

                                        <select name="cargo" id="cargo" class="form-select" required>
                                            <?php foreach ($cargos as $cargo): ?>
                                                <option value="<?= $cargo["id_cargo"] ?>" <?= $cargo["id_cargo"] == $usuario["id_cargo"] ? "selected" : "" ?>>
                                                    <?= $cargo["nome_cargo"] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <button type="submit" class="btn btn-outline-warning">Salvar</button>
                                    </form>
                                </dialog>

                                <!-- Botão Deletar -->
                                <form action="../controller/usuarios/excluirUsuario.php" method="POST" id="formInativar<?= $usuario['id_usuario'] ?>" style="display:inline;">
                                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">
                                    <button type="button" class="botao-acoes" onclick="if(confirm('Tem certeza que deseja excluir esse usuário? Essa ação é irreversível!')) document.getElementById('formInativar<?= $usuario['id_usuario'] ?>').submit()">
                                        <i class="material-icons md-delete deletar"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</main>

<?= include "./partials/footer.html" ?>
</body>
</html>
