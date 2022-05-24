<?php

use App\Http\Controllers\Admin\Cadastros\CidadeController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->name('api')->group(function () {
    Route::get('cidades', [CidadeController::class, 'pesquisar'])->name('.cidades');
});
