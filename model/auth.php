<?php
session_start();
require_once __DIR__ . "/../conexao.php";
require_once __DIR__ . "/usuario/email.php";
require_once __DIR__ . "/usuario/senha.php";

class auth
{
    public static function login(Email $email, Senha $senha): bool
    {
        global $con;

        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $con->prepare($sql);
        $email = (string) $email;
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            echo "<script>alert('E-mail ou senha incorretos, tente novamente!');window.location.href='../view/index.php'</script>";
            return false;
        }

        if (!$senha->verificarSenha($usuario["senha"])) {
            echo "<script>alert('E-mail ou senha incorretos, tente novamente!');window.location.href='../view/index.php'</script>";
            return false;
        }

        // Verifica se a senha é temporária
        if ($usuario["senha_temporaria"] == 1) {
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            echo "<script>alert('Você está usando uma senha temporária, por favor crie uma nova senha.');window.location.href='../view/alterarSenha.php'</script>";
            return false;
        }

        // Se for senha normal, faz login normalmente
        $_SESSION["nome"] = $usuario["nome_usuario"];
        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["id_cargo"] = $usuario["id_cargo"];

        echo "<script>alert('Login realizado com Sucesso!');window.location.href='../view/home.php'</script>";
        return true;
    }
}
