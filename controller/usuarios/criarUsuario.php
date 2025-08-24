<?php
 require_once __DIR__ ."/controllerUsuario.php";

 if(!$_SERVER["REQUEST_METHOD"] == 'POST') {
    header("location: ../../view/usuarios.php");
 }
 
 cadastrar_usuario();
?>