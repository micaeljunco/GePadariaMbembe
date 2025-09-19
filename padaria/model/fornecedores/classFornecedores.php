<?php

require_once __DIR__ . "/../nome.php";
require_once __DIR__ . "/cnpj.php";

class Fornecedor
{
    private int $id_fornecedor;
    private Nome $nome_fornecedor;
    private CNPJ $cnpj;
    private string $descricao;


    public function __construct(
        int $id_fornecedor,
        Nome $nome_fornecedor,
        CNPJ $cnpj,
        string $descricao,
    ) {
        $this->id_fornecedor = $id_fornecedor;
        $this->nome_fornecedor = $nome_fornecedor;
        $this->cnpj = $cnpj;
        $this->descricao = $descricao;
    }

    public function getIdFornecedor(): int
    {
        return $this->id_fornecedor;
    }
    public function getNome(): string
    {
        return $this->nome_fornecedor;
    }
    public function getCNPJ(): CNPJ
    {
        return $this->cnpj;
    }
    public function getDescricao(): string
    {
        return $this->descricao;
    }
}
