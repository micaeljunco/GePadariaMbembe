<?php

class Comanda{

    private int $id_comanda;
    private int $id_usuario;
    private float $valor_total;

    private bool $aberta;
    public function __construct(int $id_comanda, int $id_usuario, float $valor_total){
        
        $this->id_comanda = $id_comanda;
        $this->id_usuario = $id_usuario;
        $this->valor_total = $valor_total;

    }

    public function getIdComanda(): int{
        return $this->id_comanda;
    }   
    public function getIdUsuario(): int{
        return $this->id_usuario;
    }
    public function getValorTotal(): float{
        return $this->valor_total;
    }
}


?>