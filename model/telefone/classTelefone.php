<?php

class Telefone
{
    private int $id_telefone;
    private string $ddd;
    private string $numero;

    public function __construct(
        int $id_telefone,
        string $ddd,
        string $numero
    ) {
        $this->id_telefone = $id_telefone;
        $this->ddd = $ddd;
        $this->numero = $numero;
    }

    public function getDDD(): string
    {
        return (string) $this->ddd;
    }

    public function getNumero(): string
    {
        return (string) $this->numero;
    }
}
