<?php
session_start();

require_once __DIR__ . "/../../conexao.php";          // Conexão com o banco
require_once __DIR__ . "/controllerComandas.php";     // Controller da comanda

try {
    // Verifica se tem itens na comanda
    if (!isset($_SESSION["comanda_itens"]) || count($_SESSION["comanda_itens"]) === 0) {
        throw new Exception("Nenhum item na comanda para emitir.");
    }

    global $con;

    // Inicia transação
    $con->beginTransaction();

    // Dados básicos da venda/comanda
    $id_usuario = $_SESSION["id_usuario"] ?? 1; // usuário logado
    $data_hora = (new DateTime('now', new DateTimeZone('America/Sao_Paulo')))->format('Y-m-d H:i:s');
    $valor_total = $_SESSION["comanda_total"] ?? 0;

    // Insere os itens da comanda
    foreach ($_SESSION["comanda_itens"] as $item) {
        $stmtItem = $con->prepare("INSERT INTO vendas_itens (id_venda, id_item, quantidade) VALUES (:id_venda, :id_item, :quantidade)");
        $stmtItem->bindValue(":id_venda", $id_venda, PDO::PARAM_INT);
        $stmtItem->bindValue(":id_item", $item["id_item"], PDO::PARAM_INT);
        $stmtItem->bindValue(":quantidade", $item["quantidade"], PDO::PARAM_INT);
        $stmtItem->execute();

        // Atualiza estoque
        $stmtUpdate = $con->prepare("UPDATE itens SET quant = quant - :quantidade WHERE id_item = :id_item");
        $stmtUpdate->bindValue(":quantidade", $item["quantidade"], PDO::PARAM_INT);
        $stmtUpdate->bindValue(":id_item", $item["id_item"], PDO::PARAM_INT);
        $stmtUpdate->execute();
    }

    $con->commit();

    // Limpa sessão da comanda
    unset($_SESSION["comanda_itens"]);
    unset($_SESSION["comanda_total"]);

    echo "<script>
        alert('Comanda emitida com sucesso!');
        window.location.href='../../view/comandas.php';
    </script>";

} catch (Exception $e) {
    if ($con->inTransaction()) {
        $con->rollBack();
    }
    echo "<script>
        alert('Erro ao emitir comanda: " . addslashes($e->getMessage()) . "');
        window.location.href='../../view/comandas.php';
    </script>";
}