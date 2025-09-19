<?php
require_once "controllerItens.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../view/itens.php");
}

deletar_item($_POST["deletar"]);
