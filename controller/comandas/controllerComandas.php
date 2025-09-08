<?php
require_once __DIR__ . "/../../model/itens/classItens.php";
require_once __DIR__ . "/../../model/comandas/classComandas.php";
require_once __DIR__ . "/../../model/comandas/classComanda_Item.php";
require_once __DIR__ . "/../../conexao.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Garante que sempre tenha o total calculado
recalcular_total();

// 🔹 Função para adicionar item na comanda
function adicionar_item()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["item"])) {
        $valor = trim($_POST["item"]);
        $idItem = null;
        $nomeItem = null;

        if (is_numeric($valor)) {
            $idItem = $valor;
        } else {
            $nomeItem = $valor;
        }

        $quantidade = floatval($_POST["quantidade"] ?? 1);

        if ($nomeItem !== "" || $idItem !== null) {
            $item = procurarItem($idItem, $nomeItem);
            if ($item) {
                $item["quantidade"] = $quantidade;
                $_SESSION["comanda_itens"][] = $item;
            }
        }

        header("Location: ../../view/comandas.php");
        exit();
    }
}

// 🔹 Função para procurar item no banco
function procurarItem($id = null, $nome_item = null)
{
    global $con;
    $sql = "SELECT * FROM itens WHERE 1=1";
    if ($id !== null && $id !== "") {
        $sql .= " AND id_item = :id_item";
    }
    if ($nome_item !== null && $nome_item !== "") {
        $sql .= " AND nome_item = :nome_item";
    }

    $stmt = $con->prepare($sql);

    if ($id !== null && $id !== "") {
        $stmt->bindParam(":id_item", $id, PDO::PARAM_INT);
    }
    if ($nome_item !== null && $nome_item !== "") {
        $stmt->bindParam(":nome_item", $nome_item, PDO::PARAM_STR);
    }

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Função para remover item
function removerItem($index)
{
    if (isset($_SESSION["comanda_itens"][$index])) {
        unset($_SESSION["comanda_itens"][$index]);
        $_SESSION["comanda_itens"] = array_values($_SESSION["comanda_itens"]);
    }
    redirecionar();
}

// Função para recalcular total
function recalcular_total()
{
    $total = 0.0;
    if (isset($_SESSION["comanda_itens"])) {
        foreach ($_SESSION["comanda_itens"] as $item) {
            $total += $item["val_unitario"] * $item["quantidade"];
        }
    }
    $_SESSION["comanda_total"] = $total;
}

// Função para finalizar comanda
function finalizar_comanda()
{
    // Verifica se deve finalizar a comanda
    if (
        empty($_SESSION["comanda_itens"]) and empty($_SESSION["comanda_total"])
    ) {
        redirecionar();
    }
    try {
        // Cadastra uma comanda
        $id_comanda = cadastra_comanda();
        // Cadastra comanda_itens
        cadastra_comanda_itens($id_comanda);

        echo "
        <script>
            // alert('Comanda realizada com sucesso!');     Acho que fica redundante com o popup, então tirei
            window.location.href='../../view/comandas.php?resumo=$id_comanda';
        </script>";
        unset($_SESSION["comanda_total"]);
        unset($_SESSION["comanda_itens"]);
        exit();
    } catch (PDOException $e) {
        echo "
        <script>
            alert('$e');
            window.location.href='../../view/comandas.php';
        </script>";
        exit();
    }
}

// Função para cadastrar comandas
function cadastra_comanda()
{
    global $con;

    $comanda = new Comanda(0, $_SESSION["id_usuario"], new Tinyint(1));
    $sql =
        "INSERT INTO comandas (id_usuario, aberta) VALUES (:id_usuario, :aberta)";
    $stmt_comanda = $con->prepare($sql);
    $stmt_comanda->bindValue(
        ":id_usuario",
        $comanda->getIdUsuario(),
        PDO::PARAM_INT,
    );
    $stmt_comanda->bindValue(
        ":aberta",
        $comanda->getAberta()->getTinyint(),
        PDO::PARAM_INT,
    );

    if (!$stmt_comanda->execute()) {
        throw new InvalidArgumentException(
            "Erro ao cadastrar comanda no banco de dados.",
        );
    }
    return $con->lastInsertId();
}

// Função para cadastrar comandas
function cadastra_comanda_itens($id_venda)
{
    global $con;

    foreach ($_SESSION["comanda_itens"] as $item):
        $comanda_item = new ComandaItens(
            0,
            $id_venda,
            $item["id_item"],
            $item["quantidade"],
        );
        $sql =
            "INSERT INTO comanda_itens (id_comanda, id_item, quantidade) VALUES (:id_comanda, :id_item, :quantidade)";
        $stmt_comanda = $con->prepare($sql);
        $stmt_comanda->bindValue(
            ":id_comanda",
            $comanda_item->getIdComanda(),
            PDO::PARAM_INT,
        );
        $stmt_comanda->bindValue(
            ":id_item",
            $comanda_item->getItem(),
            PDO::PARAM_INT,
        );
        $stmt_comanda->bindValue(
            ":quantidade",
            $comanda_item->getQuantidade(),
            PDO::PARAM_STR,
        );

        if (!$stmt_comanda->execute()) {
            throw new InvalidArgumentException(
                "Erro ao cadastrar itens da comanda no banco de dados.",
            );
        }
    endforeach;
}

// Função para limpar/cancelar comanda
function limpar_comanda()
{
    unset($_SESSION["comanda_total"]);
    unset($_SESSION["comanda_itens"]);
    redirecionar();
}

// Função que faz o redirecionamento seguro
function redirecionar()
{
    header("Location: ../../view/comandas.php");
    exit();
}
