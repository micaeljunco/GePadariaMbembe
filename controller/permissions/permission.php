<?php
$permissoes = [
    2 => ["pdv.php", "comandas.php"],

    3 => ["itens.php", "fornecedores.php"]

];

function verificar_acesso($id): void {
    if (!verificar_permissao($id)) {
        header("Location: /gePadariaMbembe/view/home.php");
        exit();
    }
}

function verificar_permissao($id): bool{
    if($id == "1"){
        return true;
    }

    global $permissoes;
    $nomePag = basename($_SERVER["PHP_SELF"]);

    return in_array($nomePag, $permissoes[$id]);
}


function verificar_logado(): void{
    if (
        !isset($_SESSION["nome"]) ||
        !isset($_SESSION["id_usuario"]) ||
        !isset($_SESSION["id_cargo"])
    ) {
        // Melhor que usar JS, pois o usuario poderia desativá-lo.
        header("Location: ./");
        exit();
    }
}
?>