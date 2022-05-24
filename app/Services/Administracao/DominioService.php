<?php

namespace App\Services\Administracao;

use App\Models\Administracao\Dominio;

class DominioService
{
    public static function getDominioId()
    {
        if (session()->has('dominioId')) {
            return session()->get('dominioId');
        }

        if (!array_key_exists('SERVER_NAME', $_SERVER)) {
            return null;
        }

        $dominio = Dominio::where('dominio', $_SERVER['SERVER_NAME'])->first();
        session()->put('dominioId', $dominio->id);
        return $dominio->id;
    }

    public static function setDominioId($id)
    {
        /**
         * APENAS PARA TESTES VIA CONSOLE, NÃO DEVE SER USADO EM CÓDIGO
         */
        $dominio = Dominio::findOrFail($id);
        session()->put('dominioId', $dominio->id);
    }
}
