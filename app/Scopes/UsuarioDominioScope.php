<?php

namespace App\Scopes;

use App\Enums\Cadastros\Usuarios\TipoUsuarioEnum;
use App\Services\Administracao\DominioService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UsuarioDominioScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where(function ($builder) use ($model) {
            $builder->where("{$model->getTable()}.dominio_id", DominioService::getDominioId());
            $builder->orWhere("{$model->getTable()}.tipo", TipoUsuarioEnum::Admin);
        });
    }
}
