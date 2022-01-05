<?php

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

Route::name('site')->group(function(){

    Route::prefix('produto')->name('.produto')->group(function(){
        Route::get('{id}', [ProdutoController::class, 'produto'])->name('');
        Route::post('{id}/cep', [ProdutoController::class, 'atualizarCep'])->name('.cep');
    });

    Route::prefix('categoria')->name('.categoria')->group(function(){
        Route::get('{id?}', [CategoriaController::class, 'categoria'])->name('');
    });
});
