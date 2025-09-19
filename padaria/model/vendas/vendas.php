<?php

class Vendas
{
    private int $id_venda;
    private int $id_usuario;
    private ?int $id_comanda; // nulo
    private float $valor_total;
    private DateTime $data_hora; // momento exato em que a venda foi realizada

    public function __construct(
        int $id_venda,
        int $id_usuario,
        ?int $id_comanda,
        DateTime $data_hora,
        float $valor_total,
    ) {
        $this->id_venda = $id_venda;
        $this->id_usuario = $id_usuario;
        $this->id_comanda = $id_comanda;
        $this->data_hora = $data_hora;
        $this->valor_total = $valor_total;
    }

    public function getIdVenda(): int
    {
        return $this->id_venda;
    }

    public function getIdUsuario(): int
    {
        return $this->id_usuario;
    }

    public function getIdComanda(): ?int
    {
        return $this->id_comanda;
    }

    public function getDataHora(): DateTime
    {
        return $this->data_hora;
    }

    public function getValorTotal(): string
    {
        return $this->valor_total;
    }
}
