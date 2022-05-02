<?php

namespace App\Traits;

use App\Scopes\UsuarioDominioScope;
use App\Services\Administracao\DominioService;
use Illuminate\Database\Eloquent\Model;

trait UsuarioDominio
{
    public static function bootDominio()
    {
        static::addGlobalScope(new UsuarioDominioScope);

        static::creating(function (Model $model) {
            $model->dominio_id = DominioService::getDominioId();
        });
    }
}
