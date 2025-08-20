<?php
require_once "../PHP/conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeFornecedor = $_POST['nomeFornecedor'];
    $cnpjFornecedor = $_POST['cnpjFornecedor'];
    $descFornecedor = $_POST['descFornecedor'];
    $telDdd = $_POST['telDdd'];
    $telNumero = $_POST['telNumero'];

    $sql = 'INSERT INTO telefone(ddd, numero) VALUES (:telDdd, :telNumero)';
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":telDdd", $telDdd);
    $stmt->bindParam(":telNumero", $telNumero);

    if ($stmt->execute()) {
        echo "<script>
                alert('Telefone cadastrado com sucesso!');
            </script>";

        $idTelefone = $con->lastInsertId();

        $sql = "INSERT INTO fornecedores(nome_fornecedor, cnpj, descricao, id_telefone) VALUES (:nomeFornecedor, :cnpjFornecedor, :descFornecedor, :idTelefone)";

        $stmt = $con->prepare($sql);
        $stmt->bindParam(":nomeFornecedor", $nomeFornecedor);
        $stmt->bindParam(":cnpjFornecedor", $cnpjFornecedor);
        $stmt->bindParam(":descFornecedor", $descFornecedor);
        $stmt->bindParam(":idTelefone", $idTelefone);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Fornecedor cadastrado com sucesso!');
                    window.location.href = 'insert_fornecedores.html';
                </script>";

        } else {
            echo "<script>
                    alert('Erro ao cadastrar fornecedor!');
                    window.location.href = 'insert_fornecedores.html';
                </script>";
        }

    } else {
        echo "<script>
                alert('Erro ao cadastrar telefone!');
            </script>";
    }
}
exit();