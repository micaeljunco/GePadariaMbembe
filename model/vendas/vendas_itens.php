<?php

class VendaItens
{
    private int $id_venda_item;
    private int $id_venda; // F.K.
    private int $id_item; // cada item da venda

    public function __construct($id_venda_item, $id_venda, $id_item)
    {
        $this->id_venda_item = $id_venda_item;
        $this->id_venda = $id_venda;
        $this->id_item = $id_item;
    }

    public function getIdVendaItem(): int
    {
        return $this->id_venda_item;
    }

    public function getIdVenda(): int
    {
        return $this->id_venda;
    }

    public function getIdItem(): int
    {
        return $this->id_item;
    }
}
