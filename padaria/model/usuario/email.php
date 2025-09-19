<?php

class Email{
    private string $email;

    public function __construct(string $email){
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException("Email Invalido!");
            }
            $this->email = $email;
        }

    public function __toString(): string{
        return $this->email;
    }
}
?>