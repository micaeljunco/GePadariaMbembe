<?php
require_once "controllerComandas.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["item"])) {
    adicionar_item();
} else {
    redirecionar();
}
