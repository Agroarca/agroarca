<?php


namespace App\Helpers;

use InvalidArgumentException;

class Formatter
{
    public static function cpf($rawCPF){

        $cpf = preg_replace('/\D/', '', $rawCPF);

        if(!preg_match( '/^(\d{3})(\d{3})(\d{3})(\d{2})$/', $cpf,  $matches )){
            throw new InvalidArgumentException("'$rawCPF' não é um CPF válido");
        }

        return "$matches[1].$matches[2].$matches[3]-$matches[4]";
    }

    public static function cnpj($rawCNPJ){

        $cnpj = preg_replace('/\D/', '', $rawCNPJ);

        if(!preg_match( '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', $cnpj,  $matches )){
            throw new InvalidArgumentException("'$rawCNPJ' não é um CNPJ válido");
        }

        return "$matches[1].$matches[2].$matches[3]/$matches[4]-$matches[5]";
    }
}
