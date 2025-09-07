<?php

require_once __DIR__ . "/../nome.php";

class Item
{
    private int $id_item;
    private Nome $nome_itens;
    private float $quant_min;
    private float $quant;
    private string $categoria;
    private string $validade;
    private ?int $id_fornecedor; //aceita nulo
    private float $val_unitario;
    private string $unidade_medida;

    public function __construct(
        int $id_item,
        Nome $nome_itens,
        float $quant_min,
        float $quant,
        string $categoria,
        string $validade,
        ?int $id_fornecedor,
        float $val_unitario,
        string $unidade_medida,
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

    public function getNomeItem(): string
    {
        return (string) $this->nome_itens;
    }

    public function getQuantMin(): float
    {
        return $this->quant_min;
    }

    public function getQuant(): float
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

    public function getIdFornecedor(): ?int
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
    public function getIdItem(): int
    {
        return $this->id_item;
    }
}
