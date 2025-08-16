<?php

$telas = [
    "home.php" => "../img/home.png",
    "pdv.php" => "../img/pdv.png",
    "comandas.php"=> "",
    "produtos.php" => "",
    "estoque.php"=> "",
    "fornecedores.php"=> "",
    "usuarios.php"=> "",
    "logout.php"=> ""
];


?>


<div class="menu">
    <ul>
        <?php foreach($telas as $tela => $img):?>
             <?php $nomeTela = pathinfo($tela, PATHINFO_FILENAME); ?>
            <li>
                <a href="<?=htmlspecialchars($tela)?>">
                    <img src="<?=htmlspecialchars($img)?>" alt="<?=htmlspecialchars($nomeTela) ?>">
                </a>
            </li>
            <?php endforeach; ?>
    </ul>
</div>