<?php
 
require_once __DIR__ ."/controllerUsuario.php";

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: ../../view/usuarios.php");
}
if(isset($_POST["id_usuario"])){

excluir_usuario($_POST["id_usuario"]);

}
?>