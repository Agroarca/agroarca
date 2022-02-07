<?php

use App\Http\Controllers\Site\CarrinhoController;
use App\Http\Controllers\Site\CategoriaController;
use App\Http\Controllers\Site\ProdutoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Aqui devem ser registradas as rotas para o E-commerce
*/

Route::get('/', function () {
    return view('teste');
})->name('index');

Route::name('site')->group(function () {
    Route::prefix('produto')->name('.produto')->group(function () {
        Route::get('{id}', [ProdutoController::class, 'produto'])->name('');
        Route::post('{id}/cep', [ProdutoController::class, 'atualizarCep'])->name('.cep');
        Route::post('{id}/adicionar', [ProdutoController::class, 'adicionarItem'])->name('.adicionar');
    });

    Route::prefix('categoria')->name('.categoria')->group(function () {
        Route::get('{id?}', [CategoriaController::class, 'category'])->name('');
    });

    Route::prefix('carrinho')->name('.carrinho')->group(function () {
        Route::get('', [CarrinhoController::class, 'inicio'])->name('');
    });
});
