<?php
require_once __DIR__ . "/classComandas.php";
require_once __DIR__ . "/../itens/classItens.php";

class ComandaItens
{
    private int $id_comanda_itens;
    private int $id_comanda;
    private int $id_item;
    private float $quantidade; // Se for em gramas/kg precisa ser float

    public function __construct(
        int $id_comanda_itens,
        int $id_comanda,
        int $id_item,
        int $quantidade,
    ) {
        $this->id_comanda_itens = $id_comanda_itens;
        $this->id_comanda = $id_comanda;
        $this->id_item = $id_item;
        $this->quantidade = $quantidade;
    }

    public function getIdComandaItens(): int
    {
        return $this->id_comanda_itens;
    }
    public function getIdComanda(): int
    {
        return $this->id_comanda;
    }
    public function getItem(): int
    {
        return $this->id_item;
    }
    public function getQuantidade(): int
    {
        return $this->quantidade;
    }
}
