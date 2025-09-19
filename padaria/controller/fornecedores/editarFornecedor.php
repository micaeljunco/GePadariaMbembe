<?php
require_once __DIR__ ."/controllerFornecedores.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../view/fornecedores.php");
}

editar_fornecedor();

?>