<?php
require_once __DIR__ ."/controllerUsuario.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    inativar_usuario();
}

?>