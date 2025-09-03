<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ ."/../../controller/permissions/permission.php";

$idCargo = $_SESSION["id_cargo"];
?>

<nav class="menu-lateral">
    <div class="cabeca-do-menu">
        <img
            src="../src/img/icon.png"
            alt="Logo Da Padaria Mokele y Mbembe"
            class="logo"
        />
        <h1>Padaria<br />Mokele y Mbembe</h1>
    </div>

    <ul>
        <!-- Home sempre aparece -->
        <li class="item-menu">
            <a href="./home.php">
                <i class="material-icons md-home item-menu-icon"></i>
                <span>Home</span>
            </a>
        </li>

        <?php if (verificar_permissao($idCargo, "pdv.php")): ?>
        <li class="item-menu">
            <a href="./pdv.php">
                <i class="material-icons md-storefront item-menu-icon"></i>
                <span>PDV</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if (verificar_permissao($idCargo, "historicoVendas.php")): ?>
        <li class="item-menu">
            <a href="./historicoVendas.php">
                <i class="material-icons md-receipt item-menu-icon"></i>
                <span>Hist. de Vendas</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if (verificar_permissao($idCargo, "itens.php")): ?>
        <li class="item-menu">
            <a href="./itens.php">
                <i class="material-icons md-inventory_2 item-menu-icon"></i>
                <span>Inventário</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if (verificar_permissao($idCargo, "fornecedores.php")): ?>
        <li class="item-menu">
            <a href="./fornecedores.php">
                <i class="material-icons md-local_shipping item-menu-icon"></i>
                <span>Fornecedores</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if (verificar_permissao($idCargo, "usuarios.php")): ?>
        <li class="item-menu">
            <a href="./usuarios.php">
                <i class="material-icons md-group item-menu-icon"></i>
                <span>Gestão de Usuários</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if (verificar_permissao($idCargo, "comandas.php")): ?>
        <li class="item-menu">
            <a href="./comandas.php">
                <i class="material-icons md-confirmation_number item-menu-icon"></i>
                <span>Comandas</span>
            </a>
        </li>
        <?php endif; ?>

        <!-- Logout sempre aparece -->
        <li class="item-menu">
            <a href="./logout.php">
                <i class="material-icons md-logout item-menu-icon"></i>
                <span>Sair</span>
            </a>
        </li>
    </ul>
</nav>
