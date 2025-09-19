<?php

class Telefone
{
    private int $id_telefone;
    private string $ddd;
    private string $numero;
    private int $id_fornecedor;

    public function __construct(
        int $id_telefone,
        string $ddd,
        string $numero,
        int $id_fornecedor
    ) {
        $this->id_telefone = $id_telefone;
        $this->ddd = $ddd;
        $this->numero = $numero;
        $this->id_fornecedor = $id_fornecedor;
    }

    public function getIDTelefone(): int
    {
        return $this->id_telefone;
    }

    public function getDDD(): string
    {
        return (string) $this->ddd;
    }

    public function getNumero(): string
    {
        return (string) $this->numero;
    }

    public function getIdFornecedor(): int
    {
        return (int) $this->id_fornecedor;
    }
}
