<?php
require_once __DIR__ . "/controllerFornecedores.php";

if ($_SERVER["REQUEST_METHOD"] != "GET") {
}

busca_fornecedores();
header("Location: ../../view/fornecedores.php");
