<?php
require_once __DIR__ . "/controllerItens.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    cadastrar_item();
} else {
    header("Location: ../../view/itens.php");
}
