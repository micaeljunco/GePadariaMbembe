<?php

class Senha{
    private string $senhaDigitada;

    public function __construct(string $senha){
        if(strlen($senha) < 6){
            throw new InvalidArgumentException("A senha deve ter 6 ou mais caracteres!");
        }
        $this->senhaDigitada = $senha;
        
    }

    public function gerarHash(): string{
        return password_hash($this->senhaDigitada, PASSWORD_DEFAULT);
    }

    public function verificarSenha(string $senhaHash): bool{
        return password_verify($this->senhaDigitada, $senhaHash);
    }

    public function __toString(): string{
        return $this->senhaDigitada;
    }

}

?>