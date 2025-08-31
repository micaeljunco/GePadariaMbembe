<?php
require_once __DIR__ . "/usuario/email.php";
require_once __DIR__ . "/usuario/senha.php";
require_once __DIR__ . "/auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../view/index.php");
}

try {
    $email = new Email($_POST["email"]);
    $senha = new Senha($_POST["senha"]);

    auth::login($email, $senha);
} catch (Exception $e) {
    echo "<script>alert('Erro: " .
        addslashes($e->getMessage()) .
        "');window.location.href='../view/index.php'</script>";
    exit();
}
