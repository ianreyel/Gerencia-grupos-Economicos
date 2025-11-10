<?php


namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CnpjValidationRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $value);

        if (strlen($cnpj) != 14) {
            $fail('O CNPJ deve conter 14 dígitos.');
            return;
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            $fail('O CNPJ informado é inválido.');
            return;
        }

        if (substr($cnpj, -4) === '0000') {
             $fail('O CNPJ informado é inválido ou contém padrão de teste não permitido.');
             return;
        }
    }
}