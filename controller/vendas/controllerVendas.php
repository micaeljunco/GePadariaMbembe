<?php

require_once __DIR__ . "/../../conexao.php";

// Função que consulta todas as vendas com informações do vendedor e ordena pela data/hora decrescente
function consulta_vendas(): array|string
{
    global $con; // Usa a conexão global PDO

    // Query que busca id da venda, nome do usuário (vendedor), valor total e data da venda
    $sql = "
    SELECT
        v.id_venda,
        u.nome_usuario AS vendedor,
        v.valor_total,
        v.data_hora
    FROM vendas v
    JOIN usuarios u ON v.id_usuario = u.id_usuario
    ORDER BY v.data_hora DESC;";

    $stmt = $con->prepare($sql); // Prepara query para execução segura

    try {
        if ($stmt->execute()) { // Executa query e verifica sucesso
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todas as vendas em array associativo
        }
    } catch (PDOException $e) {
        // Em caso de erro no banco, retorna a mensagem da exceção
        return $e->getMessage();
    }

    // Caso execute() retorne falso, retorna mensagem padrão de erro
    return "Não foi possível realizar a consulta.";
}

// Função que realiza busca de vendas por ID exato ou pelo nome do vendedor (parcial)
// Caso $busca seja nulo, retorna todas as vendas
function busca_venda($busca): array|string
{
    global $con;

    if ($busca === null) {
        // Se nenhum parâmetro é passado, retorna todas as vendas
        return consulta_vendas();
    }

    if (is_numeric($busca) && $busca > 0) {
        // Caso $busca seja um número positivo, pesquisa venda pelo id exato
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
        $stmt->bindParam(":id", $busca, PDO::PARAM_INT); // Liga o parâmetro id para prevenir SQL Injection
    } else {
        // Caso contrário, realiza busca parcial pelo nome do vendedor usando LIKE
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
        $stmt->bindValue(":busca", "$busca%", PDO::PARAM_STR); // Busca nomes que começam com o termo informado
    }

    try {
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna resultados em array associativo
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return "Não foi possível realizar a consulta.";
}

// Função que retorna detalhes dos itens de uma venda específica
function detalhes_venda($id_venda): array|string
{
    global $con;

    // Query que busca quantidade, nome do item, unidade de medida, valor unitário e subtotal (quantidade * valor unitário)
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna detalhes dos itens da venda
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return "Não foi possível realizar a consulta.";
}

// Função que retorna os métodos de pagamento utilizados em uma venda específica
function metodos_venda($id_venda): array|string
{
    global $con;

    // Query que busca os métodos e valores pagos para a venda
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna métodos e valores pagos
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return "Não foi possível realizar a consulta.";
}
