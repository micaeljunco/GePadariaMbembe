<?php
require_once __DIR__ . "/../../model/itens/classItens.php";
require_once __DIR__ . "/../../conexao.php";

/**
 * Função para consultar todos os itens no banco.
 * Retorna um array associativo com os dados ou uma string de erro.
 */
function consulta_itens(): array|string
{
    global $con; // usa a conexão global PDO

    $sql = "SELECT * FROM itens"; // SQL para buscar todos os itens
    $stmt = $con->prepare($sql);

    try {
        if ($stmt->execute()) {
            // executa a query
            // retorna todos os registros como array associativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        // Em caso de erro, retorna a mensagem do erro
        return $e->getMessage();
    }
    // Caso não execute, retorna essa mensagem padrão
    return "Não foi possível realizar a consulta.";
}

/**
 * Função para buscar itens pelo ID ou nome (início).
 * Se $busca for null, retorna todos os itens.
 * Se for número positivo, busca pelo id_item.
 * Se for texto, busca itens cujo nome inicia com o texto.
 * Retorna array associativo ou string de erro.
 */
function busca_item($busca): array|string
{
    global $con;

    if ($busca === null) {
        // Se busca não foi passada, retorna todos os itens
        return consulta_itens();
    }

    if (is_numeric($busca) && $busca > 0) {
        // Busca pelo id_item
        $sql = "SELECT * FROM itens WHERE id_item = :id_item";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":id_item", $busca, PDO::PARAM_INT);
    } else {
        // Busca pelo nome do item que começa com $busca
        $sql = "SELECT * FROM itens WHERE nome_item LIKE :nome_item";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":nome_item", "$busca%", PDO::PARAM_STR);
    }

    try {
        if ($stmt->execute()) {
            // Retorna os resultados da busca
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    return "Não foi possível realizar a consulta.";
}

/**
 * Função para cadastrar um novo item no banco.
 * Os dados são recebidos via $_POST.
 * Em caso de sucesso, redireciona com mensagem de sucesso.
 * Em erro, mostra mensagem de erro e redireciona.
 */
function cadastrar_item(): void
{
    try {
        global $con;

        // Captura e prepara os dados recebidos do formulário
        $nome_item = new Nome($_POST["nomeItem"]);
        $quant = (float) $_POST["quant"];
        $quant_min = (float) $_POST["quantMin"];
        $categoria = (string) $_POST["categoria"];
        $unidade_medida = (string) $_POST["unidade_medida"];
        $validade = (string) $_POST["validade"];
        $id_fornecedor = (int) $_POST["idFornecedor"];
        // Ajusta fornecedor para null se valor for 0 (sem fornecedor)
        if ($id_fornecedor === 0) {
            $id_fornecedor = null;
        }
        $val_unitario = (float) $_POST["valUni"];

        // Cria um objeto Item com os dados
        $item = new Item(
            0, // id 0 pois ainda não existe
            $nome_item,
            $quant_min,
            $quant,
            $categoria,
            $validade,
            $id_fornecedor,
            $val_unitario,
            $unidade_medida,
        );

        // Prepara o comando SQL para inserção
        $sql = "INSERT INTO itens(nome_item, quant_min, quant, categoria, validade, id_fornecedor, val_unitario, unidade_medida)
            VALUES (:nome_item, :quant_min, :quant, :categoria, :validade, :id_fornecedor, :val_unitario, :unidade_medida)";

        $stmt = $con->prepare($sql);
        // Liga os valores dos parâmetros usando os getters do objeto Item
        $stmt->bindValue(":nome_item", $item->getNomeItem(), PDO::PARAM_STR);
        $stmt->bindValue(":quant_min", $item->getQuantMin(), PDO::PARAM_STR);
        $stmt->bindValue(":quant", $item->getQuant(), PDO::PARAM_STR);
        $stmt->bindValue(":categoria", $item->getCategoria(), PDO::PARAM_STR);
        $stmt->bindValue(":validade", $item->getValidade(), PDO::PARAM_STR);

        // Se id_fornecedor é null, bind como NULL no SQL, senão como INT
        if ($item->getIdFornecedor() === null) {
            $stmt->bindValue(":id_fornecedor", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(
                ":id_fornecedor",
                $item->getIdFornecedor(),
                PDO::PARAM_INT,
            );
        }

        $stmt->bindValue(":val_unitario", $item->getValUni(), PDO::PARAM_STR);
        $stmt->bindValue(":unidade_medida", $item->getUniMed(), PDO::PARAM_STR);

        // Executa a inserção e checa se ocorreu sucesso
        if (!$stmt->execute()) {
            echo "<script>alert('Não foi possivel cadastrar o item, Tente novamente!');window.location.href='../../view/itens.php'</script>";
            exit();
        }

        // Sucesso no cadastro, alerta e redireciona
        echo "<script>alert('Item cadastrado com sucesso!');window.location.href='../../view/itens.php'</script>";
        exit();
    } catch (InvalidArgumentException $e) {
        // Captura erro de argumento inválido (ex: Nome inválido)
        echo "<script>alert('" .
            addslashes($e->getMessage()) .
            "');window.location.href='../view/itens.php'</script>";
        exit();
    }
}

/**
 * Função para deletar um item dado o id.
 * Exibe alertas com sucesso ou erro e redireciona para a página de itens.
 */
function deletar_item(int $id_item): void
{
    global $con;

    $sql = "DELETE FROM itens WHERE id_item = :id_item";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id_item", $id_item, PDO::PARAM_INT);

    try {
        if ($stmt->execute()) {
            // Alerta sucesso e redireciona
            echo "<script>
                    alert('Item deletado com sucesso.');
                    window.location.href = '../../view/itens.php';
                  </script>";
        }
    } catch (PDOException $e) {
        // Caso erro de integridade referencial (item ligado a venda)
        if (
            $e->getCode() === "23000" &&
            str_contains($e->getMessage(), "1451")
        ) {
            echo "<script>
                    alert('Este item está associado a uma ou mais vendas e não pode ser deletado.');
                    window.location.href = '../../view/itens.php';
                  </script>";
        } else {
            // Qualquer outro erro de banco
            echo "<script>
                    alert('Erro ao deletar o item. Detalhes: " .
                addslashes($e->getMessage()) .
                "');
                    window.location.href = '../../view/itens.php';
                  </script>";
        }
    }
}

/**
 * Função para editar um item existente.
 * Os dados atualizados são recebidos via $_POST.
 * Busca os dados atuais, cria objeto Item com os dados novos,
 * atualiza o registro no banco.
 * Exibe alertas e redireciona para a página de itens.
 */
function editar_item(): void
{
    global $con;
    try {
        // Obtém o id do item para editar
        $id_item = (int) $_POST["id_item"];

        // Busca os dados atuais do item (não utilizados depois, pode ser para validação futura)
        $sql = "SELECT * FROM itens WHERE id_item = :id_item";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":id_item", $id_item, PDO::PARAM_INT);
        $stmt->execute();
        $infoItens = $stmt->fetch(PDO::FETCH_ASSOC);

        // Captura os dados do formulário
        $nome_item = new Nome($_POST["nomeItem"]);
        $quant_min = (float) $_POST["quantMin"];
        $quant = (float) $_POST["quant"];
        $categoria = (string) $_POST["categoria"];
        $validade = (string) $_POST["validade"];
        $id_fornecedor = (int) $_POST["idFornecedor"];

        // Ajusta fornecedor para null se 0
        if ($id_fornecedor === 0) {
            $id_fornecedor = null;
        }

        $val_unitario = (float) $_POST["valUni"];
        $unidade_medida = (string) $_POST["unidade_medida"];

        // Cria objeto Item com dados atualizados
        $item = new Item(
            0, // ID não é usado no construtor para update
            $nome_item,
            $quant_min,
            $quant,
            $categoria,
            $validade,
            $id_fornecedor,
            $val_unitario,
            $unidade_medida,
        );

        // Prepara SQL de update
        $sql = "UPDATE itens SET nome_item = :nome_item, quant_min = :quant_min, quant = :quant, categoria = :categoria,
                validade = :validade, id_fornecedor = :id_fornecedor, val_unitario = :val_unitario, unidade_medida = :unidade_medida WHERE id_item = :id_item";

        $stmt = $con->prepare($sql);
        // Liga os parâmetros usando getters do objeto Item
        $stmt->bindValue(":nome_item", $item->getNomeItem(), PDO::PARAM_STR);
        $stmt->bindValue(":quant_min", $item->getQuantMin(), PDO::PARAM_STR);
        $stmt->bindValue(":quant", $item->getQuant(), PDO::PARAM_STR);
        $stmt->bindValue(":categoria", $item->getCategoria(), PDO::PARAM_STR);
        $stmt->bindValue(":validade", $item->getValidade(), PDO::PARAM_STR);

        if ($item->getIdFornecedor() === null) {
            $stmt->bindValue(":id_fornecedor", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(
                ":id_fornecedor",
                $item->getIdFornecedor(),
                PDO::PARAM_INT,
            );
        }

        $stmt->bindValue(":val_unitario", $item->getValUni(), PDO::PARAM_STR);
        $stmt->bindValue(":unidade_medida", $item->getUniMed(), PDO::PARAM_STR);
        $stmt->bindParam(":id_item", $id_item, PDO::PARAM_INT);

        // Executa update e verifica sucesso
        if (!$stmt->execute()) {
            echo "<script>alert('Não foi possivel atualizar o item, Tente novamente!');window.location.href='../../view/itens.php'</script>";
            exit();
        }

        echo "<script>alert('Item atualizado com sucesso!');window.location.href='../../view/itens.php'</script>";
        exit();
    } catch (InvalidArgumentException $e) {
        // Captura erros de argumentos inválidos (ex: Nome inválido)
        echo "<script>alert('" .
            addslashes($e->getMessage()) .
            "');window.location.href='../view/itens.php'</script>";
        exit();
    }
}
