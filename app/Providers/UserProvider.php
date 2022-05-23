<?php

namespace App\Providers;

use App\Enums\Cadastros\Usuarios\TipoUsuarioEnum;
use App\Scopes\DominioScope;
use App\Services\Administracao\DominioService;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\ServiceProvider;

class UserProvider extends EloquentUserProvider
{
    protected function newModelQuery($model = null)
    {
        return parent::newModelQuery()
            ->withoutGlobalScope(DominioScope::class)
            ->where(function ($builder) {
                $builder->where('dominio_id', DominioService::getDominioId())
                    ->orWhere('tipo', TipoUsuarioEnum::Admin);
            });
    }
}
