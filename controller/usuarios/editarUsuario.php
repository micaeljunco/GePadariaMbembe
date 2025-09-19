<?php
require_once __DIR__ ."/controllerUsuario.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../view/usuarios.php");
}

editar_usuario();

?>