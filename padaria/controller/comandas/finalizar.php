<?php
require_once "controllerComandas.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    finalizar_comanda();
} else {
    redirecionar();
}
