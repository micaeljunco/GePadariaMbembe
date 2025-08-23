<?php
 require_once __DIR__ ."/controllerUsuario.php";

 if($_SERVER["REQUEST_METHOD"] == 'POST') {
    cadastrar_usuario();
 }else{
    header("location: ../../view/usuarios.php");
 }
?>