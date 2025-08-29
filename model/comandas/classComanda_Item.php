<?php
require_once __DIR__ ."/classComandas.php";
require_once __DIR__ ."/../itens/classItens.php";


class Comanda_Item{

    private Comanda $comanda;
    private Item $item;
    private int $quantidade;

    public function __construct(Comanda $comanda, Item $item, int $quantidade){
        $this->comanda = $comanda;
        $this->item = $item;
        $this->quantidade = $quantidade;
    }

    public function getIdComanda(): int{
        return $this->comanda->getIdComanda();
    }
    public function getItem(): int{
        return $this->item->getIdItem();
    }
    public function getQuantidade(): int{
        return $this->quantidade;
    }

}

?>