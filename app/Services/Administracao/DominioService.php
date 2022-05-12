<?php

namespace App\Services\Administracao;

use App\Models\Administracao\Dominio;
use Illuminate\Database\Schema\Blueprint;

class DominioService
{
    public static function getDominioId()
    {
        if (session()->has('dominioId')) {
            return session()->get('dominioId');
        }

        //$dominio = Dominio::where('dominio', $_SERVER['SERVER_NAME'])->first();
        $dominio = Dominio::find(1);
        session()->put('dominioId', $dominio->id);
        return $dominio->id;
    }
}
