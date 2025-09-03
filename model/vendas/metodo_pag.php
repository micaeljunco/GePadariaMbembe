<?php

class MetodoPagamento
{
    private int $id_metodo; // PK
    private int $id_venda; // FK para vendas
    private string $metodo; // ex.: "Dinheiro", "Cartão", "PIX"
    private float $valor_pago; // quanto foi pago nesse método

    public function __construct(
        int $id_metodo,
        int $id_venda,
        string $metodo,
        float $valor_pago,
    ) {
        $this->id_metodo = $id_metodo;
        $this->id_venda = $id_venda;
        $this->metodo = $metodo;
        $this->valor_pago = $valor_pago;
    }

    // Getters
    public function getIdMetodo(): int
    {
        return $this->id_metodo;
    }

    public function getIdVenda(): int
    {
        return $this->id_venda;
    }

    public function getMetodo(): string
    {
        return $this->metodo;
    }

    public function getValorPago(): float
    {
        return $this->valor_pago;
    }
}
