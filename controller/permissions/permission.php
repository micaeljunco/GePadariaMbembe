<?php
// Define um array associativo onde a chave é o ID do cargo
// e o valor é um array com os nomes dos arquivos/páginas que o usuário pode acessar.
$permissoes = [
    2 => ["pdv.php", "comandas.php"], // Usuário com cargo com ID 2 pode acessar pdv.php e comandas.php
    3 => ["itens.php", "fornecedores.php"], // Usuário com cargo com ID 3 pode acessar itens.php e fornecedores.php
];

// Função para verificar se o usuário tem acesso permitido para a página atual.
// Recebe o ID do cargo.
function verificar_acesso($id): void
{
    // Se o usuário não tem permissão para acessar a página atual,
    // redireciona para a página home.php e encerra a execução.
    if (!verificar_permissao($id)) {
        header("Location: /GePadariaMbembe/view/home.php");
        exit();
    }
}

// Função que verifica se o usuário tem permissão para acessar uma página.
// Recebe o ID do cargo e opcionalmente o nome da página.
// Retorna true se tem permissão, false caso contrário.
function verificar_permissao($id, string $pagina = null): bool
{
    // O usuário com ID 1 é considerado administrador e tem acesso total.
    if ($id == 1) {
        return true;
    }

    // Usa a variável global $permissoes para verificar permissões.
    global $permissoes;

    // Se a página não for informada, pega o nome do arquivo PHP da requisição atual.
    $pagina = $pagina ?? basename($_SERVER["PHP_SELF"]);

    // Verifica se existe permissão definida para esse ID e se a página está na lista de páginas permitidas.
    return isset($permissoes[$id]) && in_array($pagina, $permissoes[$id], true);
}

// Função para verificar se o usuário está logado corretamente.
// Verifica se as variáveis de sessão essenciais estão definidas.
function verificar_logado(): void
{
    if (
        !isset($_SESSION["nome"]) || // Nome do usuário
        !isset($_SESSION["id_usuario"]) || // ID do usuário
        !isset($_SESSION["id_cargo"]) // ID do cargo do usuário
    ) {
        // Se alguma dessas variáveis não estiver definida, significa que o usuário não está logado.
        // Redireciona para a página inicial (login) e encerra a execução.
        // Usar redirecionamento PHP é mais seguro do que usar JavaScript, pois o JS pode ser desativado no navegador.
        header("Location: ../");
        exit();
    }
}
?>
