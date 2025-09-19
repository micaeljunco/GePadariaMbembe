<?php
require_once "controllerItens.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../view/itens.php");
}

editar_item();
