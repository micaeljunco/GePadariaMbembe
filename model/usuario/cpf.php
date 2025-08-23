<?php

class Cpf{

    private string $cpf;

    public function __construct(string $cpf){

        if(strlen($cpf) != 11){
            throw new InvalidArgumentException("O CPF deve conter 11 digitos!");
        }
        $this->cpf = $cpf;
    }

    public function __toString(): string{
        return $this->cpf;
    }
}
?>