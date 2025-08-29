<?php

require_once __DIR__ . "/../nome.php";

class Item
{
    private int $id_item;
    private Nome $nome_itens;
    private int $quant_min;
    private int $quant;
    private string $categoria;
    private string $validade;
    private int $id_fornecedor;
    private float $val_unitario;
    private string $unidade_medida;

    public function __construct(
        int $id_item,
        Nome $nome_itens,
        int $quant_min,
        int $quant,
        string $categoria,
        string $validade,
        int $id_fornecedor,
        float $val_unitario,
        string $unidade_medida
    ) {
        $this->id_item = $id_item;
        $this->nome_itens = $nome_itens;
        $this->quant_min = $quant_min;
        $this->quant = $quant;
        $this->categoria = $categoria;
        $this->validade = $validade;
        $this->id_fornecedor = $id_fornecedor;
        $this->val_unitario = $val_unitario;
        $this->unidade_medida = $unidade_medida;
    }

    public function __toString(): string
    {
        return (string) $this->nome_itens;
    }

    public function getQuantMin(): int
    {
        return $this->quant_min;
    }

    public function getQuant(): int
    {
        return $this->quant;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getValidade(): string
    {
        return $this->validade;
    }

    public function getIdFornecedor(): int
    {
        return $this->id_fornecedor;
    }

    public function getValUni(): float
    {
        return $this->val_unitario;
    }

    public function getUniMed(): string
    {
        return $this->unidade_medida;
    }
    public function getIdItem(): int{
        return $this->id_item;
    }
}
