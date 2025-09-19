<?php
function gerarSenhaTemporaria(int $tamanho = 8): string {
    if ($tamanho < 6) {
        $tamanho = 8;
    }

    $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($caracteres), 0, $tamanho);
}

function simularEnvioEmail($destinatario, $senha) {

    $mensagem = "Olá! Sua nova senha temporária é: $senha\n";

    $registro = "Para: $destinatario\n$mensagem\n----------------------\n";
    
    file_put_contents("emails_simulados.txt", $registro, FILE_APPEND);
}
?>