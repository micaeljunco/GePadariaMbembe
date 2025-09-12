<?php

require_once __DIR__ . "/../../conexao.php";

function aviso_estoque_critico(): array|string
{
    global $con;

    $sql = "
        SELECT id_item, nome_item, quant, quant_min
        FROM itens
        WHERE quant <= quant_min
    ";

    try {
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($resultados)) {
            return $resultados;
        } else {
            return "Nenhum item em estoque crítico.";
        }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
}

function mais_vendidos(): array|string
{
    global $con;

    $sql = "
        SELECT i.nome_item, i.unidade_medida, SUM(vi.quantidade) AS total_vendido
        FROM vendas_itens vi
        INNER JOIN itens i ON vi.id_item = i.id_item
        INNER JOIN vendas v ON vi.id_venda = v.id_venda
        WHERE MONTH(v.data_hora) = MONTH(CURDATE())
        AND YEAR(v.data_hora) = YEAR(CURDATE())
        GROUP BY i.id_item, i.nome_item
        ORDER BY total_vendido DESC
        LIMIT 5;
    ";
    try {
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($resultados)) {
            return $resultados;
        } else {
            return "Nenhuma informação pôde ser obtida.";
        }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
}

function faturamento_dia(): array|string
{
    global $con;

    $sql = "
        SELECT DATE(data_hora) AS dia, SUM(valor_total) AS faturamento
        FROM vendas
        WHERE DATE(data_hora) = CURDATE()
        GROUP BY dia;
    ";
    try {
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($resultados)) {
            return $resultados;
        } else {
            return "Nenhuma informação pôde ser obtida.";
        }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
}

function faturamento_mes(): array|string
{
    global $con;

    $sql = "
        SELECT MONTH(data_hora) AS mes, YEAR(data_hora) AS ano, SUM(valor_total) AS faturamento
        FROM vendas
        WHERE MONTH(data_hora) = MONTH(CURDATE())
        AND YEAR(data_hora) = YEAR(CURDATE())
        GROUP BY mes, ano;
    ";
    try {
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($resultados)) {
            return $resultados;
        } else {
            return "Nenhum faturamento este mês.";
        }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
}

function ticket_medio(): array|string
{
    global $con;

    $sql = "
        SELECT AVG(valor_total) AS ticket_medio
        FROM vendas
        WHERE DATE(data_hora) = CURDATE();
    ";
    try {
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($resultados)) {
            return $resultados;
        } else {
            return "Nenhuma informação pôde ser obtida.";
        }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
}

function horario_pico(): array|string
{
    global $con;

    $sql = "
        SELECT HOUR(data_hora) AS hora, COUNT(*) AS qtd_vendas
        FROM vendas
        WHERE DATE(data_hora) = CURDATE()
        GROUP BY hora
        ORDER BY qtd_vendas DESC
        LIMIT 1;
    ";
    try {
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($resultados)) {
            return $resultados;
        } else {
            return "Nenhuma informação pôde ser obtida.";
        }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
}
