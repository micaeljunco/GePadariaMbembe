<?php
require_once __DIR__ ."/controllerPdv.php";

if($_SERVER["REQUEST_METHOD"] !== 'POST') {
    header("location: ../../view/pdv.php");
 }
 
 adicionar_item();
?>