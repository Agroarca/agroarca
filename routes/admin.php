<?php

use App\Http\Controllers\Cadastros\EstadoController;
use App\Http\Controllers\Cadastros\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Aqui devem ser registradas as rotas para o painel administrativo da
| Aplicação.
|
*/

Route::middleware(['auth'])->prefix('admin')->name('admin')->group(function(){

    Route::namespace('Cadastros')->prefix('cadastros')->name('.cadastros')->group(function(){

        Route::prefix('estados')->name('.estados')->group(function (){
            Route::get('', [EstadoController::class, 'inicio'])->name('');
            Route::get('editar/{id}', [EstadoController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [EstadoController::class, 'atualizar'])->name('.atualizar');
        });

        Route::prefix('usuarios')->name('.usuarios')->group(function (){
            Route::get('', [UsuarioController::class, 'inicio'])->name('');
            Route::get('editar/{id}', [UsuarioController::class, 'editar'])->name('.editar');
        });
    });
});
