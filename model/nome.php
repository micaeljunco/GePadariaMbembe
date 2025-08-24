<?php

class Nome
{
    private string $nome;

    public function __construct(string $nome)
    {
        if (strlen($nome) < 3) {
            throw new InvalidArgumentException(
                "O nome deve ter mais que 3 caracteres!",
            );
        }
        $this->nome = $nome;
    }

    public function __toString(): string
    {
        return $this->nome;
    }
}
