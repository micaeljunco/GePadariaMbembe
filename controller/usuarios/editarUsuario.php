<?php
require_once __DIR__ ."/controllerUsuario.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    editar_usuario();
}else{
    header("Location: ../../view/usuarios.php");
}

?>