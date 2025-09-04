<?php

require_once __DIR__ . "/../../conexao.php";

function consulta_vendas(): array|string
{
    global $con;

    $sql = "
    SELECT
        v.id_venda,
        u.nome_usuario AS vendedor,
        v.valor_total,
        v.data_hora
    FROM vendas v
    JOIN usuarios u ON v.id_usuario = u.id_usuario
    ORDER BY v.data_hora DESC;";

    $stmt = $con->prepare($sql);

    try {
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }

    return "Não foi possível realizar a consulta.";
}

function busca_venda($busca): array|string
{
    global $con;

    if ($busca === null) {
        return consulta_vendas();
    }

    if (is_numeric($busca) && $busca > 0) {
        $sql = "
        SELECT
            v.id_venda,
            u.nome_usuario AS vendedor,
            v.valor_total,
            v.data_hora
        FROM vendas v
        JOIN usuarios u ON v.id_usuario = u.id_usuario
        WHERE v.id_venda = :id
        ORDER BY v.data_hora DESC;";

        $stmt = $con->prepare($sql);
        $stmt->bindParam(":id", $busca, PDO::PARAM_INT);
    } else {
        $sql = "
        SELECT
            v.id_venda,
            u.nome_usuario AS vendedor,
            v.valor_total,
            v.data_hora
        FROM vendas v
        JOIN usuarios u ON v.id_usuario = u.id_usuario
        WHERE u.nome_usuario LIKE :busca
        ORDER BY v.data_hora DESC;";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(":busca", "$busca%", PDO::PARAM_STR);
    }

    try {
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return "Não foi possível realizar a consulta.";
}

function detalhes_venda($id_venda): array|string
{
    global $con;

    $sql = "
    SELECT
        vi.quantidade,
        i.nome_item,
        i.unidade_medida,
        i.val_unitario,
        (vi.quantidade * i.val_unitario) AS subtotal
    FROM vendas_itens vi
    JOIN itens i ON vi.id_item = i.id_item
    WHERE vi.id_venda = :id_venda;";

    try {
        $stmt = $con->prepare($sql);

        $stmt->bindParam(":id_venda", $id_venda, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return "Não foi possível realizar a consulta.";
}

function metodos_venda($id_venda): array|string
{
    global $con;

    $sql = "
    SELECT
        metodo,
        valor_pago
    FROM metodos_pag
    WHERE id_venda = :id_venda;";

    try {
        $stmt = $con->prepare($sql);

        $stmt->bindParam(":id_venda", $id_venda, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return "Não foi possível realizar a consulta.";
}
