<?php
require_once "../PHP/conexao.php";


if ($_SERVER['REQUEST_METHOD'] == "POST" && is_numeric($_POST["idFornecedor"])) {
    // Guarda o ID fornecido via post em uma variavel
    $idFornecedor = (int) $_POST["idFornecedor"];

    // Verifica se o id solicitado para exclusao tem informações na tabela
    $sql = "SELECT id_fornecedor FROM fornecedores WHERE id_fornecedor = :idFornecedor";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(":idFornecedor", $idFornecedor);

    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        echo "<script>
            alert('Fornecedor não encontrado! Verifique o ID inserido.');
            window.location.href = 'delete_fornecedores.html';
        </script>";
        exit();
    }
    // Caso o fornecedor exista, segue com a deleção

    // DELETA OS DADOS DA TABELA TELEFONE ANTES POIS AS ESTÁ ATRELADA AO FORNECEDOR COM CHAVE ESTRANGEIRA
    $sql = "DELETE FROM telefone WHERE id_telefone = :idFornecedor";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(":idFornecedor", $idFornecedor);

    $stmt->execute();

    // Segue com a deleção do fornecedor
    $sql = "DELETE FROM fornecedores WHERE id_fornecedor = :idFornecedor";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(":idFornecedor", $idFornecedor);

    $stmt->execute();

    echo "<script>
        alert('Sucesso ao deletar fornecedor!');
        window.location.href = 'delete_fornecedores.html';
    </script>";
}

exit();