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

function verificar_permissao($id, string $pagina = null): bool {
    if ($id == 1) { // Admin
        return true;
    }

    global $permissoes;
    $pagina = $pagina ?? basename($_SERVER["PHP_SELF"]);

    return isset($permissoes[$id]) && in_array($pagina, $permissoes[$id], true);
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