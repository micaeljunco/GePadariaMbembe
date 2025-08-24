<?php

require_once __DIR__ . "/nome_item.php";

class Item
{
    private int $id_item;
    private NomeItem $nome_item;
    private int $quant_min;
    private int $quant;
    private string $categoria;
    private string $validade;
    private int $id_fornecedor;
    private float $val_unitario;

    public function __construct(
        int $id_item,
        NomeItem $nome_item,
        int $quant_min,
        int $quant,
        string $categoria,
        string $validade,
        int $id_fornecedor,
        float $val_unitario,
    ) {
        $this->id_item = $id_item;
        $this->nome_item = $nome_item;
        $this->quant_min = $quant_min;
        $this->quant = $quant;
        $this->categoria = $categoria;
        $this->validade = $validade;
        $this->id_fornecedor = $id_fornecedor;
        $this->val_unitario = $val_unitario;
    }

    public function getNomeItem(): string
    {
        return (string) $this->nome_item;
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
}
