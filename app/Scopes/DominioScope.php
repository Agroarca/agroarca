<?php

namespace App\Scopes;

use App\Services\Administracao\DominioService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DominioScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where("{$model->getTable()}.dominio_id", DominioService::getDominioId());
    }
}
