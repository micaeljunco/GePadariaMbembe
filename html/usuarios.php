<?php
    session_start();
    require_once("../PHP/exibirUsuarios.php");
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
    <link rel="stylesheet" href="../css/ListaPadrao.css">
      
</head>
<body>

    <main class="container">

            <dialog class="popupContainer" id="popup">
                <img src="../img/Fechar.png" alt="Fechar" onclick="document.getElementById('popup').close()">

                <div class="popup">
                    <form action="../PHP/criarUsuario.php">
                        <input type="text" placeholder="Nome" class="form-control">
                        <input type="text" placeholder="Senha" class="form-control">
                        <input type="text" placeholder="Email" class="form-control">
                        <select name="cargo" id="cargo" class="form-select">
                            <?php foreach($cargos as $cargo):?>
                                <option value="<?=htmlspecialchars($cargo["nome_cargo"])?>"><?php echo $cargo["nome_cargo"]?></option>
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
                    
                </div>
                <div class="cadastro">
                    <button class="btn btn-outline-warning" onclick="document.getElementById('popup').showModal()">Cadastrar Usuários</button>
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

                            <td><?php $usuario["id_cargo"] == 1 ? print "Administrador" : print "sem cargo"; ?></td>

                            <td>
                                <div class="acoes">
                                    <div class="editar">
                                            <img src="../img/edit.png" alt="Editar" type="button">
                                    </div>

                                    <div class="excluir">
                                            <img src="../img/delete.png" alt="Excluir" type="button">
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