<?php

class Tinyint
{
    private int $tinyint;

    public function __construct(int $tinyint)
    {
        if ($tinyint > 1 or $tinyint < 0) {
            throw new InvalidArgumentException("O valor dado deve ser 0 ou 1!");
        }
        $this->tinyint = $tinyint;
    }

    public function getTinyint(): int
    {
        return $this->tinyint;
    }
}
