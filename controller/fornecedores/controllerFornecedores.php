<?php
require_once __DIR__ . "/../../model/fornecedores/classFornecedores.php";
require_once __DIR__ . "/../../controller/telefone/controllerTelefone.php";
require_once __DIR__ . "/../../conexao.php";

function consulta_fornecedores(): array|string
{
    global $con;

    $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
    FROM fornecedores
    LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone
    ORDER BY fornecedores.nome_fornecedor ASC";
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
function busca_fornecedores()
{
    global $con;

    // Se o formulario for enviado busca o fornecedor pelo id ou nome
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["busca"])) {
        $busca = trim($_GET["busca"]);

        // Verifica se a busca é um numero ou um nome
        if (is_numeric($busca)) {
            $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
                    FROM fornecedores
                    LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone
                    WHERE id_fornecedor = :busca
                    ORDER BY nome_fornecedor ASC";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(":busca", $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
                    FROM fornecedores
                    LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone
                    WHERE nome_fornecedor LIKE :busca
                    ORDER BY nome_fornecedor ASC";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":busca", "$busca%", PDO::PARAM_STR);
        }
    } else {
        // Query normal
        $sql = "SELECT fornecedores.*, telefone.numero, telefone.ddd
                FROM fornecedores
                LEFT JOIN telefone ON fornecedores.id_telefone = telefone.id_telefone
                ORDER BY fornecedores.nome_fornecedor ASC";
        $stmt = $con->prepare($sql);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
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

function alterar_fornecedor()
{
    global $con;
    //inicializa variaveis.
    $fornecedor = null;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["busca_fornecedor"])) {
            $busca = trim($_POST["busca_fornecedor"]);

            //Verifica se a busca e um numero (id) ou um nome.
            if (is_numeric($busca)) {
                $sql =
                    "SELECT * FROM fornecedores WHERE id_fornecedor = :busca";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(":busca", $busca, PDO::PARAM_INT);
            } else {
                $sql =
                    "SELECT * FROM fornecedores WHERE nome_fornecedor LIKE :busca_nome";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":busca_nome", "$busca%", PDO::PARAM_STR);
            }
            $stmt->execute();
            $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC); // Corrigido: era $fornecedor, deve ser $fornecedor

            //Se o fornecedor nao for encontrado, exibe um alerta.
            if (!$fornecedor) {
                echo "<script>alert('Fornecedor não encontrado!');</script>";
            }
        }
    }
    return $fornecedor; // Adicionado retorno da função
}

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

function cadastrar_fornecedor(): void
{
    try {
        global $con;

        $nome_fornecedor = new Nome($_POST["nomeFornecedor"]);
        $cnpj = new CNPJ($_POST["cnpjFornecedor"]);
        $desc = (string) $_POST["descFornecedor"];
        $telefone = (string) $_POST["telefone"];

        // Regex para capturar o DDD e o número
        if (
            preg_match('/^\((\d{2})\)\s*(\d{4,5}-\d{4})$/', $telefone, $matches)
        ) {
            $ddd = $matches[1]; // "47"
            $numero = $matches[2]; // "9999-9999" ou "99999-9999"
        } else {
            // Formato inválido
            throw new Exception("Formato de telefone inválido");
        }

        $id_telefone = cadastrar_telefone($ddd, $numero);

        $fornecedor = new Fornecedor(
            0,
            $nome_fornecedor,
            $cnpj,
            $desc,
            $id_telefone,
        );

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
        echo "<script>alert('" .
            addslashes($e->getMessage()) .
            "');window.location.href='../view/fornecedores.php'</script>";
        exit();
    }
}

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
 *  POR FAVOR ALGUEM CORRIJA
 *  NÂO ESTOU CONSEGUINDO FAZER A EDIÇÂO DO TELEFONE
 *  no código abaixo, caso tente editar, o id será 0, o que fará o
 *  fornecedor ficar sem telefone algum.
 **/

function editar_fornecedor(): void
{
    global $con;
    try {
        $id_fornecedor = (int) $_POST["id_fornecedor"];
        $nome_fornecedor = new Nome($_POST["nomeFornecedor"]);
        $cnpj = new CNPJ($_POST["cnpjFornecedor"]);
        $desc = (string) $_POST["descFornecedor"];
        $telefone = (string) $_POST["telefone"];
        $id_telefone = obterIdTelefoneFornecedor($id_fornecedor);

        // Regex para capturar o DDD e o número
        if (
            preg_match('/^\((\d{2})\)\s*(\d{4,5}-\d{4})$/', $telefone, $matches)
        ) {
            $ddd = $matches[1]; // "47"
            $numero = $matches[2]; // "9999-9999" ou "99999-9999"
        } else {
            // Formato inválido
            throw new Exception("Formato de telefone inválido");
        }

        editar_telefone($id_telefone, $ddd, $numero);

        $fornecedor = new Fornecedor(
            $id_fornecedor,
            $nome_fornecedor,
            $cnpj,
            $desc,
            $id_telefone,
        );

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
