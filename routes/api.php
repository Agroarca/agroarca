<?php

use App\Http\Controllers\Admin\Cadastros\CidadeController;
use App\Http\Controllers\Admin\Cadastros\UsuarioController;
use App\Http\Controllers\Admin\Pedidos\PedidoController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->name('api')->group(function () {
    Route::get('cidades', [CidadeController::class, 'pesquisar'])->name('.cidades');

    Route::middleware(['auth'])->group(function () {
        Route::get('usuarios', [UsuarioController::class, 'pesquisar'])->name('.usuarios');
        Route::get('produtos', [PedidoController::class, 'produtos'])->name('.produtos');
        Route::get('itensListaPreco', [PedidoController::class, 'itensListaPreco'])->name('.itensListaPreco');
    });
});
