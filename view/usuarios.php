<?php
    session_start();
    require_once __DIR__ ."/../controller/usuarios/controllerUsuario.php";
    
    $usuarios = buscar_usuario();
    $cargos = buscar_cargos();

    $cargosMapa = [
        1 => "Administrador",
        2 => "Caixa",
        3 => "Controlador de Estoque"
    ];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <!-- Link do Bootstrap -->
     <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <!-- Link do CSS -->
    <link rel="stylesheet" href="../css/padrao.css">
    <link rel="stylesheet" href="../css/usuarios.css">
    <link rel="stylesheet" href="../css/listaPadrao.css">
      
</head>
<body>

    <main class="container">

            <!-- PopUp de Cadastrar Usuarios -->
            <dialog class="popupContainer" id="criarPopup">
                <div class="nomePopup">
                    <h2>Cadastro de Usuarios</h2>
                </div>
                <img src="../img/Fechar.png" alt="Fechar" onclick="document.getElementById('criarPopup').close()">

                <div class="popup">
                    <form action="../controller/usuarios/criarUsuario.php" method="POST">
                        <input type="text" name="nome" placeholder="Nome" class="form-control">
                        <input type="text" name="senha" placeholder="Senha" class="form-control">
                        <input type="email" name="email" placeholder="Email" class="form-control">
                        <input type="text" name="cpf" placeholder="CPF" class="form-control">
                            <select name="cargo" id="cargo" class="form-select">
                                <?php foreach($cargos as $cargo):?>
                                    <option value="<?=$cargo["id_cargo"]?>"><?php echo $cargo["nome_cargo"]?></option>
                                <?php endforeach;?>
                            </select>
                            <button type="submit" class="btn btn-outline-warning">Salvar</button>    
                    </form>
                    
                </div>
            </dialog>




        <div class="nomePag">
            <h1>Gestão de Usuários</h1>
        </div>

        <div class="tabela">
            <div class="interacao">
                <div class="busca">
                    <input type="text" class="form-control" placeholder="Pesquisar Usuário">
                    <button class="btn btn-outline-warning">Buscar</button>
                    

                    <form action="../controller/usuarios/exibirInativados.php?inativado=1" method="GET">
                        <button class="btn btn-outline-warning" id="btnInativados">Exibir Inativados</button>
                    </form>
                </div>

                <div class="cadastro">
                    <button class="btn btn-outline-warning" onclick="document.getElementById('criarPopup').showModal()">Cadastrar Usuários</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Cargo</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    <?php foreach($usuarios as $usuario):?>
                        <tr>
                            <td><?php echo $usuario["id_usuario"]?></td>

                            <td><?php echo $usuario["nome_usuario"]?></td>

                            <td><?php echo $usuario["email"]?></td>

                            <td><?php echo $cargosMapa[$usuario["id_cargo"]]?></td>

                            <td>
                                <div class="acoes">
                                    <div class="editar">
                                            <img src="../img/edit.png" alt="Editar" onclick="document.getElementById('editarPopup<?=$usuario['id_usuario']?>').showModal()">
                                            <dialog class="popupContainer" id="editarPopup<?=$usuario['id_usuario']?>">
                                                <div class="nomePopup">
                                                    <h2>Editar Usuarios</h2>
                                                </div>
                                                <img src="../img/Fechar.png" alt="Fechar" onclick="document.getElementById('editarPopup<?=$usuario['id_usuario']?>').close()">

                                                <div class="popup">
                                                    <form action="../controller/usuarios/editarUsuario.php" method="POST">
                                                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?=htmlspecialchars($usuario['id_usuario'])?>">

                                                        <input type="text" name="nome" placeholder="Nome" class="form-control" value="<?=htmlspecialchars($usuario['nome_usuario'])?>">

                                                        <input type="text" name="email" placeholder="Email" class="form-control" value="<?=htmlspecialchars($usuario['email'])?>">

                                                            <select name="cargo" id="cargo" class="form-select">
                                                                <?php foreach($cargos as $cargo):?>
                                                                    <option value="<?=$cargo["id_cargo"]?>"><?php echo $cargo["nome_cargo"]?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                            <button type="submit" class="btn btn-outline-warning">Salvar</button>    
                                                    </form>
                                                    
                                                </div>
                                        </dialog>


                                    </div>

                                    <div class="excluir">
                                        <form action="../controller/usuarios/inativarUsuario.php" method="POST" id="formInativar<?=$usuario['id_usuario']?>" style="display: inline;">
                                                <input type="hidden" name="id_usuario" value="<?=htmlspecialchars($usuario['id_usuario'])?>">
                                                <img src="../img/inativar.png" alt="Inativar usuario" onclick="document.getElementById('formInativar<?=$usuario['id_usuario']?>').submit()">
                                       
                                        </form>
                                            
                                    </div>
                                </div>
                            </td>
                        </tr>
                            
                    <?php endforeach;?>
                </tbody>
            </table>

        </div>

    </main>
    
</body>
</html>