<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include_once "../PHP/conexao.php"
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- link do bootstrap -->
    <link rel="stylesheet" href="../bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <!-- links Css -->
     <link rel="stylesheet" href="../css/padrao.css">
     <link rel="stylesheet" href="../css/loginYan.css"> 
</head>
<body>
    <!-- corpo principal da pagina -->
    <main class="conteiner">
        <!-- div da parte amarela e a msg bonita, parte esquerda da pagina -->
            <div class="amarelo">
                <h1 class="text-center">Bem vindo!</h1>
                <h2 class="text-center">Padaria <br> Mokele y Mbembe</h2>
            </div>

            <!-- div do formulario, ou seja a parte direita da pagina -->
            <div class="formulario">

                <!-- topo do formulario, com a logo e a msg login -->
                <div id="topoForm">
                    <h1>Login</h1>
                    <img src="../img/icon.png" alt="logoMokele">
                </div>
                
                <!-- inicio do formulario -->
                <form action="../PHP/validarLogin.php" method="POST">

                    <!-- div com as informações que o usuario vai inserir(inputs) -->
                    <div id="formInfo">
                        <input type="text" class="form-control" placeholder="Nome" required name="nome">
                        <br>

                        <div id="formSenha">
                            <input type="password" class="form-control" placeholder="Senha" required id="senha" name="senha">
                            <img src="../img/exibir_senha.png" alt="Exibir senha" onclick="vizualizacao()">
                        </div>
                    </div>
                    
                    <br>

                    <!-- div com os 2 botões de interação(esqueceu senha e o de logar) -->
                    <div id="botoes">
                    <p><a href="#">Esqueceu sua senha</a></p>

                    <button type="submit" class="btn btn-outline-warning">Logar</button>
                    </div>
                    
                </form>
            </div>
    </main>

    <script>
        function vizualizacao(){

            const senha = document.getElementById("senha")
            if (senha.type === "text"){
                senha.type = "password"
            }
            else{
                senha.type = "text"
            }
            }
        
    </script>

    <?php
    if (isset($con)) {
        mysqli_close($con);
    }
?>
    
</body>
</html>