<?php

namespace App\Traits;

use App\Scopes\DominioScope;
use App\Services\Administracao\DominioService;
use Illuminate\Database\Eloquent\Model;

trait Dominio
{
    public static function bootDominio()
    {
        static::addGlobalScope(new DominioScope);

        static::creating(function (Model $model) {
            $model->dominio_id = DominioService::getDominioId();
        });
    }
}
