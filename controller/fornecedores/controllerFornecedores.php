<?php
// Inclui classes e controladores necessários para manipulação de fornecedores e telefones, além da conexão com o banco
require_once __DIR__ . "/../../model/fornecedores/classFornecedores.php";
require_once __DIR__ . "/../../controller/telefone/controllerTelefone.php";
require_once __DIR__ . "/../../conexao.php";

/**
 * Consulta todos os fornecedores com seus respectivos telefones (se houver).
 * Retorna um array associativo com os dados ou uma string com a mensagem de erro.
 */
function consulta_fornecedores(): array|string
{
    global $con;

    // Consulta SQL para pegar fornecedores e seus telefones (LEFT JOIN para incluir fornecedores sem telefone)
    $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
            FROM fornecedores
            LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone
            ORDER BY fornecedores.id_fornecedor DESC";
    $stmt = $con->prepare($sql);

    try {
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        return $e->getMessage(); // Retorna mensagem de erro caso falhe
    }
    return "Não foi possível realizar a consulta.";
}

/**
 * Busca fornecedores pelo parâmetro GET 'busca', que pode ser ID ou nome.
 * Se nenhum parâmetro for enviado, retorna todos os fornecedores.
 */
function busca_fornecedores()
{
    global $con;

    if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["busca"])) {
        $busca = trim($_GET["busca"]);

        if (is_numeric($busca)) {
            // Busca por ID exato
            $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
                    FROM fornecedores
                    LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone
                    WHERE id_fornecedor = :busca
                    ORDER BY id_fornecedor DESC";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":busca", $busca, PDO::PARAM_INT);
        } else {
            // Busca por nome que inicia com o valor informado
            $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
                    FROM fornecedores
                    LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone
                    WHERE nome_fornecedor LIKE :busca
                    ORDER BY nome_fornecedor ASC";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":busca", "$busca%", PDO::PARAM_STR);
        }
    } else {
        return consulta_fornecedores();
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Retorna o nome do fornecedor dado um ID (item_id_fornecedor).
 * Se não houver fornecedor, retorna "Nenhum".
 */
function fornecedor_item(?int $item_id_fornecedor): string
{
    if ($item_id_fornecedor === null) {
        return "Nenhum";
    }

    global $con;

    $sql =
        "SELECT nome_fornecedor FROM fornecedores WHERE id_fornecedor = :item_id_fornecedor";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(
        ":item_id_fornecedor",
        $item_id_fornecedor,
        PDO::PARAM_INT,
    );

    try {
        $stmt->execute();
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fornecedor) {
            return "Nenhum";
        }
    } catch (PDOException $e) {
        return "Erro: " . $e->getMessage();
    }

    return $fornecedor["nome_fornecedor"];
}

/**
 * Função para alterar fornecedor, buscando por ID ou nome via POST.
 * Retorna os dados do fornecedor encontrado ou null.
 */
function alterar_fornecedor()
{
    global $con;
    $fornecedor = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["busca_fornecedor"])) {
            $busca = trim($_POST["busca_fornecedor"]);

            if (is_numeric($busca)) {
                // Busca por ID
                $sql =
                    "SELECT * FROM fornecedores WHERE id_fornecedor = :busca";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(":busca", $busca, PDO::PARAM_INT);
            } else {
                // Busca por nome com início igual ao termo buscado
                $sql =
                    "SELECT * FROM fornecedores WHERE nome_fornecedor LIKE :busca_nome";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":busca_nome", "$busca%", PDO::PARAM_STR);
            }
            $stmt->execute();
            $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$fornecedor) {
                echo "<script>alert('Fornecedor não encontrado!');</script>";
            }
        }
    }
    return $fornecedor;
}

/**
 * Deleta fornecedor do banco pelo ID.
 * Mostra alertas de sucesso ou erro e redireciona para a página de fornecedores.
 */
function deletar_fornecedores($id_fornecedor)
{
    global $con;

    $sql = "DELETE FROM fornecedores WHERE id_fornecedor = :id_fornecedor";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id_fornecedor", $id_fornecedor, PDO::PARAM_INT);

    try {
        if ($stmt->execute()) {
            echo "<script>alert('Fornecedor deletado com sucesso.');window.location.href = '../../view/fornecedores.php'</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Não foi possível realizar a operação. Detalhes: " .
            $e->getMessage() .
            "');window.location.href = '../../view/fornecedores.php'</script>";
    }
}

/**
 * Cadastra um novo fornecedor.
 * Recebe dados do formulário via POST, cria objeto Fornecedor e insere no banco.
 * Valida telefone e cadastra telefone antes de vincular ao fornecedor.
 */
function cadastrar_fornecedor(): void
{
    try {
        global $con;

        // Criação dos objetos Nome e CNPJ usando os dados do POST
        $nome_fornecedor = new Nome($_POST["nomeFornecedor"]);
        $cnpj = new CNPJ($_POST["cnpjFornecedor"]);
        $desc = (string) $_POST["descFornecedor"];
        $telefone = (string) $_POST["telefone"];

        // Validação e extração do DDD e número via regex
        if (
            preg_match('/^\((\d{2})\)\s*(\d{4,5}-\d{4})$/', $telefone, $matches)
        ) {
            $ddd = $matches[1];
            $numero = $matches[2];
        } else {
            throw new Exception("Formato de telefone inválido");
        }

        // Cadastra telefone e obtém seu ID
        $id_telefone = cadastrar_telefone($ddd, $numero);

        // Cria o objeto fornecedor com id 0 (novo)
        $fornecedor = new Fornecedor(
            0,
            $nome_fornecedor,
            $cnpj,
            $desc,
            $id_telefone,
        );

        // Insere fornecedor no banco
        $sql = "INSERT INTO fornecedores(nome_fornecedor, cnpj, descricao, id_telefone)
            VALUES (:nome_fornecedor, :cnpj, :descricao, :id_telefone)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(
            ":nome_fornecedor",
            $fornecedor->getNome(),
            PDO::PARAM_STR,
        );
        $stmt->bindValue(":cnpj", $fornecedor->getCNPJ(), PDO::PARAM_STR);
        $stmt->bindValue(
            ":descricao",
            $fornecedor->getDescricao(),
            PDO::PARAM_STR,
        );
        $stmt->bindValue(
            ":id_telefone",
            $fornecedor->getIdTelefone(),
            PDO::PARAM_INT,
        );

        if (!$stmt->execute()) {
            echo "<script>alert('Não foi possivel cadastrar o fornecedor, Tente novamente!');window.location.href='../../view/fornecedores.php'</script>";
            exit();
        }

        echo "<script>alert('Fornecedor cadastrado com sucesso!');window.location.href='../../view/fornecedores.php'</script>";
        exit();
    } catch (InvalidArgumentException $e) {
        // Captura erros de validação e redireciona com alerta
        echo "<script>alert('" .
            addslashes($e->getMessage()) .
            "');window.location.href='../view/fornecedores.php'</script>";
        exit();
    }
}

/**
 * Obtém o ID do telefone associado a um fornecedor pelo seu ID.
 */
function obterIdTelefoneFornecedor($id_fornecedor): int
{
    global $con;

    $sql =
        "SELECT id_telefone FROM fornecedores WHERE id_fornecedor = :id_fornecedor";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(":id_fornecedor", $id_fornecedor, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_OBJ);
    return $resultado->id_telefone;
}

/**
 * Edita um fornecedor existente.
 * Atualiza nome, CNPJ, descrição e telefone.
 * Problema comentado: ao editar telefone, o id_telefone pode ser 0, removendo telefone do fornecedor.
 */
function editar_fornecedor(): void
{
    global $con;
    try {
        $id_fornecedor = (int) $_POST["id_fornecedor"];
        $nome_fornecedor = new Nome($_POST["nomeFornecedor"]);
        $cnpj = new CNPJ($_POST["cnpjFornecedor"]);
        $desc = (string) $_POST["descFornecedor"];
        $telefone = (string) $_POST["telefone"];

        // Obtém o ID do telefone atual do fornecedor
        $id_telefone = obterIdTelefoneFornecedor($id_fornecedor);

        // Valida e extrai DDD e número do telefone
        if (
            preg_match('/^\((\d{2})\)\s*(\d{4,5}-\d{4})$/', $telefone, $matches)
        ) {
            $ddd = $matches[1];
            $numero = $matches[2];
        } else {
            throw new Exception("Formato de telefone inválido");
        }

        // Atualiza o telefone no banco
        editar_telefone($id_telefone, $ddd, $numero);

        // Cria objeto fornecedor atualizado
        $fornecedor = new Fornecedor(
            $id_fornecedor,
            $nome_fornecedor,
            $cnpj,
            $desc,
            $id_telefone,
        );

        // Atualiza dados do fornecedor no banco
        $sql = "UPDATE fornecedores
                SET nome_fornecedor = :nome_fornecedor,
                    cnpj = :cnpj,
                    descricao = :descricao,
                    id_telefone = :id_telefone
                WHERE id_fornecedor = :id_fornecedor";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(
            ":id_fornecedor",
            $fornecedor->getIdFornecedor(),
            PDO::PARAM_INT,
        );
        $stmt->bindValue(
            ":nome_fornecedor",
            $fornecedor->getNome(),
            PDO::PARAM_STR,
        );
        $stmt->bindValue(":cnpj", $fornecedor->getCNPJ(), PDO::PARAM_STR);
        $stmt->bindValue(
            ":descricao",
            $fornecedor->getDescricao(),
            PDO::PARAM_STR,
        );
        $stmt->bindValue(
            ":id_telefone",
            $fornecedor->getIdTelefone(),
            PDO::PARAM_INT,
        );

        if (!$stmt->execute()) {
            echo "<script>alert('Não foi possivel editar o fornecedor, Tente novamente!');window.location.href='../../view/fornecedores.php'</script>";
            exit();
        }

        echo "<script>alert('Fornecedor editado com sucesso!');window.location.href='../../view/fornecedores.php'</script>";
        exit();
    } catch (InvalidArgumentException $e) {
        echo "<script>alert('" .
            addslashes($e->getMessage()) .
            "');window.location.href='../view/fornecedores.php'</script>";
        exit();
    }
}
