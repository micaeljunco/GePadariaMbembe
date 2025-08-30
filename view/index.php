<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- link do bootstrap -->
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <!-- links Css -->
    <link rel="stylesheet" href="../css/padrao.css">
    <link rel="stylesheet" href="../css/login.css">
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
                <img src="../img/icon.png" alt="logoMokele">
            </header>


            <form action="../model/validarLogin.php" method="POST">
                <div class="input-container">
                    <input type="email" class="form-control" placeholder="E-mail" name="email" required>
                </div>

                <div class="input-container" id="container-senha">
                    <input type="password" class="form-control" placeholder="Senha" id="senha" name="senha" required>
                    <i alt="Exibir senha" id="senha-olho" class="input-icon material-icons md-visibility_off" onclick="vizualizacao()"></i>
                </div>

                <div id="esq-senha"><a href="#">Esqueci minha senha</a></div>
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
</body>
</html>
