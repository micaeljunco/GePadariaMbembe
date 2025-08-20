<?php

require_once "../PHP/conexao.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit();
}

$nome_item = $_POST['nomeItem'];
$quant_min = $_POST['qtdeMinItem'];
$quant = $_POST['qtdeItem'];
$categoria = $_POST['catItem'];
$validade = $_POST['valiItem'];
$id_fornecedor = $_POST['idFornItem'];
$val_unitario = $_POST['valUniItem'];

$sql = 'INSERT INTO itens(nome_item, quant_min, quant, categoria, validade, id_fornecedor, val_unitario) VALUES(:nome_item, :quant_min, :quant, :categoria, :validade, :id_fornecedor, :val_unitario)';
$stmt = $con->prepare($sql);
$stmt->bindParam(":nome_item",$nome_item, PDO::PARAM_STR);
$stmt->bindParam(":quant_min", $quant_min, PDO::PARAM_INT);
$stmt->bindParam(":quant", $quant, PDO::PARAM_INT);
$stmt->bindParam(":categoria", $categoria);
$stmt->bindParam(":validade",$validade, PDO::PARAM_STR);
$stmt->bindParam(":id_fornecedor", $id_fornecedor, PDO::PARAM_INT);
$stmt->bindParam(":val_unitario", $val_unitario);

if ($stmt->execute()) {
    echo "<script>
        alert('Item cadastrado com sucesso!');
        window.location.href = 'insert_itens.php';
    </script>";
} else {
    echo "<script>
        alert('Não foi possível cadastrar o item!');
        window.location.href = 'insert_itens.php';
    </script>";
}

exit();

