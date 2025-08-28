<?php
require_once "controllerFornecedores.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../view/fornecedores.php");
}

deletar_fornecedores($_POST["deletar"]);
