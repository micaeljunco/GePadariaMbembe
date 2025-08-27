<?php
require_once __DIR__ ."/controllerFornecedor.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../view/fornecedores.php");
}

editar_fornecedor();

?>