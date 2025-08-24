<?php
require_once __DIR__ . "/controllerItens.php";

if (!$_SERVER["REQUEST_METHOD"] == "POST") {
    header("Location: ../../view/itens.php");
}

cadastrar_item();
?>
