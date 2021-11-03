<?php

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
    });

    Route::prefix('categoria')->name('.categoria')->group(function(){
        Route::get('{id}',function(){
            return 'categoria';
        })->name('');
    });
});
