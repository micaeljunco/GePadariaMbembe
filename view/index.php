<?php
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- link do bootstrap -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <!-- links Css -->
    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/login.css">
    <link rel="icon" type="image/png" href="../src/img/icon.png">
</head>
<body>
    <main id="login-page">

        <!-- Parte amarela com mensagem (esquerda) -->
        <div id="login-titulo">
            <h1>Bem-vindo!</h1>
            <h2>Padaria <br> Mokele y Mbembe</h2>
        </div>

        <!-- Conteúdo do login (direita) -->
        <div id="login-conteudo">
            <header>
                <h1>Login</h1>
                <img src="../src/img/icon.png" alt="logoMokele">
            </header>


            <form action="../model/validarLogin.php" method="POST">
                <div class="input-container">
                    <input type="email" class="form-control" placeholder="E-mail" name="email" required>
                </div>

                <div class="input-container" id="container-senha">
                    <input type="password" class="form-control" placeholder="Senha" id="senha" name="senha" required>
                    <i alt="Exibir senha" id="senha-olho" class="input-icon material-icons md-visibility_off" onclick="vizualizacao()"></i>
                </div>

                <div id="esq-senha"><a onclick="document.getElementById('popupEsqueceuSenha').showModal()">Esqueci minha senha</a></div>
                <button type="submit" class="btn" id="btn-entrar">Entrar</button>
            </form>
        </div>

    </main>

    <script>
    function vizualizacao(){
        const senha = document.getElementById("senha");
        const olho = document.getElementById("senha-olho");

        if(senha.type === "password"){
            senha.type = "text";
            olho.classList.replace("md-visibility_off", "md-visibility"); // olho aberto
        } else {
            senha.type = "password";
            olho.classList.replace("md-visibility", "md-visibility_off"); // olho fechado
        }
    }
    </script>


    <!-- Popup de Esqueceu a senha -->
     <dialog id="popupEsqueceuSenha" class="popupContainer">
        <div class="nomePopup text-center">
            <h1>Esqueceu a senha</h1>
            <i class="material-icons md-close" onclick="document.getElementById('popupEsqueceuSenha').close()"></i>
        </div>
        <div class="h-100 w-100 overflow-y-auto">
            <form action="../controller/recuperarSenha/controllerRecuperarSenha.php" method="POST" class="d-flex flex-column justify-content-center align-items-center">
                <label for="Email">Digite o seu E-mail para receber o codigo:</label>
                <input type="email" name="email" class="form-control" required>
                <button class="btn btn-outline-warning">Enviar Codigo</button> 
            </form>
            <form action="">
                <label for="codigo">Digite o Codigo:</label>
                <input type="text" class="form-control">
                <button class="btn btn-outline-warning">Confirmar Codigo</button>
            </form>
        </div>
        
     </dialog>
</body>
</html>
