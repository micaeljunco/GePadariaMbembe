<?php
require_once __DIR__ ."/../../model/fornecedores/classFornecedores.php";
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
function fornecedor_item(int $item_id_fornecedor): string
{
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
function excluirFornecedor()
{
    global $con;
    //Se um id for passado via GET excluir o fornecedor
    if (isset($_POST['id_fornecedor']) && is_numeric($_POST['id_fornecedor'])) {
        $id_fornecedor = $_POST['id_fornecedor'];

        // Excluir o fornecedor do banco de dados.
        $sql = "DELETE FROM fornecedores WHERE id_fornecedor = :id";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id', $id_fornecedor, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Usuário excluído com sucesso!');window.location.href='excluir_usuario.php'</script>";
        } else {
            echo "<script>alert('Erro ao excluir o usuario!');</script>";
        }
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
        if (preg_match('/^\((\d{2})\)\s*(\d{4,5}-\d{4})$/', $telefone, $matches)) {
            $ddd = $matches[1];      // "47"
            $numero = $matches[2];   // "9999-9999" ou "99999-9999"
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
            $id_telefone
        );

        $sql = "INSERT INTO fornecedores(nome_fornecedor, cnpj, descricao, id_telefone)
            VALUES (:nome_fornecedor, :cnpj, :descricao, :id_telefone)";

        $stmt = $con->prepare($sql);

        $stmt->bindValue(":nome_fornecedor", $fornecedor->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(":cnpj", $fornecedor->getCNPJ(), PDO::PARAM_STR);
        $stmt->bindValue(":descricao", $fornecedor->getDescricao(), PDO::PARAM_STR);
        $stmt->bindValue(":id_telefone", $fornecedor->getIdTelefone(), PDO::PARAM_INT);

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