<?php

use App\Http\Controllers\Site\CarrinhoController;
use App\Http\Controllers\Site\CategoriaController;
use App\Http\Controllers\Site\PerfilController;
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

    Route::middleware(['auth'])->group(function () {
        Route::prefix('perfil')->name('.perfil')->group(function () {
            Route::get('', [PerfilController::class, 'inicio'])->name('');
            Route::post('', [PerfilController::class, 'atualizar'])->name('.atualizar');

            Route::prefix('enderecos')->name('.enderecos')->group(function () {
                Route::get('adicionar', [PerfilController::class, 'adicionarEndereco'])->name('.adicionar');
                Route::post('salvar', [PerfilController::class, 'salvarEndereco'])->name('.salvar');
                Route::get('excluir/{id}', [PerfilController::class, 'excluirEndereco'])->name('.excluir');
                Route::get('selecionar_padrao/{id}', [PerfilController::class, 'selecionarPadrao'])->name('.selecionarPadrao');
            });
        });

        Route::prefix('carrinho')->name('.carrinho')->group(function () {
            Route::get('continuar', [CarrinhoController::class, 'continuar'])->name('.continuar');
            Route::post('finalizar', [CarrinhoController::class, 'finalizar'])->name('.finalizar');
            Route::post('selecionarFormaPagamento/{id}', [CarrinhoController::class, 'selecionarFormaPagamento'])->name('.selecionarFormaPagamento');
            Route::post('alterarDataPagamento', [CarrinhoController::class, 'alterarDataPagamento'])->name('.alterarDataPagamento');
            Route::post('alterarDataEntrega', [CarrinhoController::class, 'alterarDataEntrega'])->name('.alterarDataEntrega');
            Route::get('resumo', [CarrinhoController::class, 'resumo'])->name('.resumo');

            Route::prefix('enderecos')->name('.enderecos')->group(function () {
                Route::get('adicionar', [CarrinhoController::class, 'adicionarEndereco'])->name('.adicionar');
                Route::post('salvar', [CarrinhoController::class, 'salvarEndereco'])->name('.salvar');
                Route::post('excluir/{id}', [CarrinhoController::class, 'excluirEndereco'])->name('.excluir');
                Route::post('selecionar/{id}', [CarrinhoController::class, 'selecionarEndereco'])->name('.selecionar');
            });
        });
    });
});
