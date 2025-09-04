<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/padrao.css">
    <link rel="stylesheet" href="../src/css/esqueceuSenha.css">
</head>
<body>

    <main id="esqueceuSenha">

        <div class="nomePopup">
            <h1>Redefinir Senha</h1>
        </div>
        <form action="../controller/recuperarSenha/alterarSenha.php" method="POST">
            <label for="Senha">Digite sua Senha:</label>
            <input type="password" name="novaSenha" class="form-control">

            <label for="ConfirmarSenha">Confirme sua Senha:</label>
            <input type="password" name="confirmarSenha" class="form-control">
            
            <button class="btn btn-outline-warning" type="submit" >Mudar Senha</button>
        </form>
        
    </main>
    
</body>
</html>