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
    // @TODO: Futuramente mover para controller e juntamente das logicas necessarias.
    $flash_sale = true;

    return view('site.home', compact('flash_sale'));
})->name('inicio');

Route::name('site')->group(function () {
    Route::prefix('produto')->name('.produto')->group(function () {
        Route::get('{id}', [ProdutoController::class, 'produto'])->name('');
        Route::post('{id}/cep', [ProdutoController::class, 'atualizarCep'])->name('.cep');
        Route::post('{id}/adicionar', [ProdutoController::class, 'adicionarItem'])->name('.adicionar');
    });

    Route::prefix('categoria')->name('.categoria')->group(function () {
        Route::get('{id?}', [CategoriaController::class, 'categoria'])->name('');
    });

    Route::prefix('carrinho')->name('.carrinho')->group(function () {
        Route::get('', [CarrinhoController::class, 'inicio'])->name('');
        Route::get('remover/{item_id}', [CarrinhoController::class, 'remover'])->name('.remover');
        Route::get('item/{item_id}/editar', [CarrinhoController::class, 'editar'])->name('.editar');
        Route::post('item/{item_id}/salvar', [CarrinhoController::class, 'salvar'])->name('.salvar');
        Route::post('item/{item_id}/alterar_quantidade', [CarrinhoController::class, 'alterar_quantidade'])->name('.alterar_quantidade');
    });
});
