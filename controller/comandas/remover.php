<?php
require_once "controllerComandas.php";

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["remover"])) {
    removerItem($_GET["remover"]);
} else {
    redirecionar();
}
