<?php

namespace App\Traits;

use App\Scopes\UsuarioDominioScope;
use App\Services\Administracao\DominioService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

trait UsuarioDominio
{
    public static function bootUsuarioDominio()
    {
        static::addGlobalScope(new UsuarioDominioScope);

        static::creating(function (Model $model) {
            $model->dominio_id = DominioService::getDominioId();
        });
    }

    public static function criarCampo(Blueprint $table, $nullable = false)
    {
        $table->foreignId('dominio_id')->nullable($nullable);
        $table->foreign('dominio_id')->references('id')->on('dominios');
    }

    public static function removerCampo(Blueprint $table)
    {
        $table->dropForeign(['dominio_id']);
        $table->dropColumn('dominio_id');
    }
}
