<?php

use App\Http\Controllers\Cadastros\CidadeController;
use App\Http\Controllers\Cadastros\EstadoController;
use App\Http\Controllers\Cadastros\UsuarioController;
use App\Http\Controllers\Cadastros\UsuarioEnderecoController;
use App\Http\Controllers\Estoque\MarcaController;
use App\Models\Cadastros\UsuarioEndereco;
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

        Route::prefix('cidades')->name('.cidades')->group(function (){
            Route::get('', [CidadeController::class, 'inicio'])->name('');
            Route::get('criar/', [CidadeController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [CidadeController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [CidadeController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [CidadeController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [CidadeController::class, 'excluir'])->name('.excluir');
        });

        Route::prefix('usuarios')->name('.usuarios')->group(function (){
            Route::get('', [UsuarioController::class, 'inicio'])->name('');
            Route::get('editar/{id}', [UsuarioController::class, 'editar'])->name('.editar');

            Route::prefix('{userId}/enderecos')->name('.enderecos')->group(function (){
                Route::get('criar/', [UsuarioEnderecoController::class, 'criar'])->name('.criar');
                Route::post('salvar/', [UsuarioEnderecoController::class, 'salvar'])->name('.salvar');
                Route::get('editar/{id}', [UsuarioEnderecoController::class, 'editar'])->name('.editar');
                Route::post('atualizar/{id}', [UsuarioEnderecoController::class, 'atualizar'])->name('.atualizar');
                Route::get('excluir/{id}', [UsuarioEnderecoController::class, 'excluir'])->name('.excluir');
            });
        });
    });

    Route::namespace('Estoque')->prefix('estoque')->name('.estoque')->group(function(){

        Route::prefix('marcas')->name('.marcas')->group(function (){
            Route::get('', [MarcaController::class, 'inicio'])->name('');
            Route::get('criar/', [MarcaController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [MarcaController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [MarcaController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [MarcaController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [MarcaController::class, 'excluir'])->name('.excluir');
        });

    });
});
