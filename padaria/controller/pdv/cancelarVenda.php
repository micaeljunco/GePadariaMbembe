<?php
require_once __DIR__ ."/controllerPdv.php";

if (isset($_POST["limpar"]) and $_POST["limpar"] == 1) {
    limpar_venda(true);
}

if($_SERVER["REQUEST_METHOD"] !== 'POST') {
    header("location: ../../view/pdv.php");
}
