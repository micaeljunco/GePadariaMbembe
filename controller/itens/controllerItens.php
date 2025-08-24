<?php
require_once __DIR__ . "/../../model/itens/classItens.php";
require_once __DIR__ . "/../../conexao.php";

function consulta_itens(): array
{
    global $con;

    $sql = "SELECT * FROM itens";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    return $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cadastrar_item(): void
{
    try {
        global $con;

        $nome_item = new NomeItem($_POST["nomeItem"]);
        $quant_min = (int) $_POST["quantMin"];
        $quant = (int) $_POST["quant"];
        $categoria = (string) $_POST["categoria"];
        $validade = (string) $_POST["validade"];
        $id_fornecedor = (int) $_POST["idFornecedor"];
        $val_unitario = (float) $_POST["valUni"];

        $item = new Item(
            0,
            $nome_item,
            $quant_min,
            $quant,
            $categoria,
            $validade,
            $id_fornecedor,
            $val_unitario,
        );

        $sql = "INSERT INTO itens(nome_item, quant_min, quant, categoria, validade, id_fornecedor, val_unitario)
            VALUES (:nome_item, :quant_min, :quant, :categoria, :validade, :id_fornecedor, :val_unitario)";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(":nome_item", $item->getNomeItem(), PDO::PARAM_STR);
        $stmt->bindValue(":quant_min", $item->getQuantMin(), PDO::PARAM_INT);
        $stmt->bindValue(":quant", $item->getQuant(), PDO::PARAM_INT);
        $stmt->bindValue(":categoria", $item->getCategoria(), PDO::PARAM_STR);
        $stmt->bindValue(":validade", $item->getValidade(), PDO::PARAM_STR);
        $stmt->bindValue(
            ":id_fornecedor",
            $item->getIdFornecedor(),
            PDO::PARAM_INT,
        );
        $stmt->bindValue(":val_unitario", $item->getValUni(), PDO::PARAM_STR);

        if (!$stmt->execute()) {
            echo "<script>alert('Não foi possivel cadastrar o item, Tente novamente!');window.location.href='../../view/itens.php'</script>";
            exit();
        }
        
        echo "<script>alert('Item cadastrado com sucesso!');window.location.href='../../view/itens.php'</script>";
        exit();
        
        
    } catch (InvalidArgumentException $e) {
        echo "<script>alert('" .
            addslashes($e->getMessage()) .
            "');window.location.href='../view/itens.php'</script>";
        exit();
    }
}
