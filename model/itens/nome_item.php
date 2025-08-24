<?php

class NomeItem
{
    private string $nome_item;

    public function __construct(string $nome_item)
    {
        if (strlen($nome_item) < 3) {
            throw new InvalidArgumentException(
                "O nome_item do item deve ter mais que 3 caracteres!",
            );
        }
        $this->nome_item = $nome_item;
    }

    public function __toString(): string
    {
        return $this->nome_item;
    }
}
