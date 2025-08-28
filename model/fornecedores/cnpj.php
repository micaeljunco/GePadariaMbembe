<?php

class CNPJ
{
    private string $cnpj;

    public function __construct(string $cnpj)
    {
        // Limpa caracteres não numéricos
        $cnpj = preg_replace('/\D/', '', $cnpj);

        // Valida comprimento (CNPJ tem 14 dígitos)
        if (strlen($cnpj) !== 14) {
            throw new InvalidArgumentException("CNPJ inválido: deve conter 14 dígitos.");
        }

        // (Opcional) Validação estrutural real do CNPJ
        if (!$this->validaCNPJ($cnpj)) {
            throw new InvalidArgumentException("CNPJ inválido.");
        }

        $this->cnpj = $cnpj;
    }

    public function __toString(): string
    {
        return $this->formataCNPJ($this->cnpj);
    }

    private function formataCNPJ(string $cnpj): string
    {
        return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $cnpj);
    }

    private function validaCNPJ(string $cnpj): bool
    {
        // CNPJ inválido conhecido
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Validação do dígito verificador
        for ($t = 12; $t < 14; $t++) {
            $d = 0;
            $c = 0;
            for ($m = $t - 7, $i = 0; $i < $t; $i++) {
                $d += $cnpj[$i] * $m--;
                if ($m < 2) $m = 9;
            }

            $r = $d % 11 < 2 ? 0 : 11 - $d % 11;
            if ($cnpj[$i] != $r) return false;
        }

        return true;
    }
}

