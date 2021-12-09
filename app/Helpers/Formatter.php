<?php

namespace App\Helpers;

use Carbon\Carbon;
use InvalidArgumentException;

class Formatter
{
    public static function cpf($rawCPF){
        if(empty($rawCPF)){
            return $rawCPF;
        }

        $cpf = preg_replace('/\D/', '', $rawCPF);

        if(!preg_match( '/^(\d{3})(\d{3})(\d{3})(\d{2})$/', $cpf,  $matches )){
            throw new InvalidArgumentException("'$rawCPF' não é um CPF válido");
        }

        return "$matches[1].$matches[2].$matches[3]-$matches[4]";
    }

    public static function cnpj($rawCNPJ){
        if(empty($rawCNPJ)){
            return $rawCNPJ;
        }

        $cnpj = preg_replace('/\D/', '', $rawCNPJ);

        if(!preg_match( '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', $cnpj,  $matches )){
            throw new InvalidArgumentException("'$rawCNPJ' não é um CNPJ válido");
        }

        return "$matches[1].$matches[2].$matches[3]/$matches[4]-$matches[5]";
    }

    public static function telefone($rawTelefone){
        if(empty($rawTelefone)){
            return $rawTelefone;
        }

        $telefone = preg_replace('/\D/', '', $rawTelefone);

        if(!preg_match( '/^(\d{2})(\d{4})(\d{1})?(\d{4})$/', $telefone,  $matches )){
            throw new InvalidArgumentException("'$rawTelefone' não é um Telefone válido");
        }

        return "($matches[1]) $matches[2]$matches[3]-$matches[4]";
    }

    public static function date($date){
        return Carbon::parse($date)->format('d/m/Y');
    }

    public static function datetime($datetime){
        return Carbon::parse($datetime)->format('d/m/Y H:i:s');
    }

    public static function preco($preco){
        return 'R$ ' . number_format($preco, 2, ',', '.');
    }
}
