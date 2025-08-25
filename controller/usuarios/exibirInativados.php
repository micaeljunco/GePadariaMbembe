<?php
require_once __DIR__ ."/controllerUsuario.php";

if($_GET["inativo"] !== "1") {
    header("Location: ../../view/usuarios.php");
}

ExibirUsuarioInativo($_GET["inativo"]);



?>