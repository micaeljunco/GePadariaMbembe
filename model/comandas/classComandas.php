<?php
require_once "../tinyint.php";

class Comanda
{
    private int $id_comanda;
    private int $id_usuario;
    private Tinyint $aberta; // O status padrão da comanda é aberta (1)

    public function __construct(
        int $id_comanda,
        int $id_usuario,
        Tinyint $aberta,
    ) {
        $this->id_comanda = $id_comanda;
        $this->id_usuario = $id_usuario;
        $this->aberta = $aberta;
    }

    public function getIdComanda(): int
    {
        return $this->id_comanda;
    }
    public function getIdUsuario(): int
    {
        return $this->id_usuario;
    }
    public function getAberta(): Tinyint
    {
        return $this->aberta;
    }
}
