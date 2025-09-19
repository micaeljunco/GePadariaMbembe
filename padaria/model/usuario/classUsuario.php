<?php

require_once __DIR__ ."/cpf.php";
require_once __DIR__ ."/nome.php";
require_once __DIR__ ."/email.php";
require_once __DIR__ ."/senha.php";


class Usuario {

    private int $id_usuario;
    private Cpf $cpf;
    private Nome $nome;
    private Email $email;
    private string $senhaHash;
    private int $id_cargo;


    public function __construct(Nome $nome, Cpf $cpf, Email $email, string $senhaHash, int $id_cargo, int $id_usuario) {

        $this->id_usuario = $id_usuario;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->senha = $senhaHash;
        $this->id_cargo = $id_cargo;
    }

    public function getCpf(): string{
        return (string) $this->cpf;
    }

    public function getNome(): string{
        return (string) $this->nome;
    }
    
    public function getEmail(): string{
        return (string) $this->email;
    }

    public function getSenha(): string{
        return (string) $this->senhaHash;
    }

    public function getIdUsuario(): int{
        return $this->id_usuario;
    }

    public function getIdCargo(): int{
        return $this->id_cargo;
    }

}


?>