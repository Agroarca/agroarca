<?php

use App\Http\Controllers\Admin\Cadastros\CentroDistribuicaoController;
use App\Http\Controllers\Admin\Cadastros\CidadeController;
use App\Http\Controllers\Admin\Cadastros\EstadoController;
use App\Http\Controllers\Admin\Cadastros\UsuarioController;
use App\Http\Controllers\Admin\Cadastros\UsuarioEnderecoController;
use App\Http\Controllers\Admin\Estoque\CategoriaController;
use App\Http\Controllers\Admin\Estoque\ICMSProdutoEstadoController;
use App\Http\Controllers\Admin\Estoque\MarcaController;
use App\Http\Controllers\Admin\Estoque\ProdutoController;
use App\Http\Controllers\Admin\Estoque\ProdutoImagemController;
use App\Http\Controllers\Admin\Estoque\TipoProdutoController;
use App\Http\Controllers\Admin\PainelController;
use App\Http\Controllers\Admin\Pedidos\ItemListaPrecoController;
use App\Http\Controllers\Admin\Pedidos\ListaPrecoController;
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

Route::middleware(['auth'])->prefix('admin')->name('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Routes
    |--------------------------------------------------------------------------
    |
    | Aqui devem conter todas as rotas para o dashboard e relatórios
    |
    */

    Route::get('inicio', [PainelController::class, 'inicio'])->name('.inicio');

    /*
    |--------------------------------------------------------------------------
    | Model Routes
    |--------------------------------------------------------------------------
    |
    | Aqui devem conter todas as rotas para crud de modelos
    |
    */

    Route::prefix('cadastros')->name('.cadastros')->group(function () {

        Route::prefix('estados')->name('.estados')->group(function () {
            Route::get('', [EstadoController::class, 'inicio'])->name('');
            Route::get('editar/{id}', [EstadoController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [EstadoController::class, 'atualizar'])->name('.atualizar');
        });

        Route::prefix('cidades')->name('.cidades')->group(function () {
            Route::get('', [CidadeController::class, 'inicio'])->name('');
            Route::get('criar/', [CidadeController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [CidadeController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [CidadeController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [CidadeController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [CidadeController::class, 'excluir'])->name('.excluir');
        });

        Route::prefix('usuarios')->name('.usuarios')->group(function () {
            Route::get('', [UsuarioController::class, 'inicio'])->name('');
            Route::get('editar/{id}', [UsuarioController::class, 'editar'])->name('.editar');

            Route::prefix('{userId}/enderecos')->name('.enderecos')->group(function () {
                Route::get('criar/', [UsuarioEnderecoController::class, 'criar'])->name('.criar');
                Route::post('salvar/', [UsuarioEnderecoController::class, 'salvar'])->name('.salvar');
                Route::get('editar/{id}', [UsuarioEnderecoController::class, 'editar'])->name('.editar');
                Route::post('atualizar/{id}', [UsuarioEnderecoController::class, 'atualizar'])->name('.atualizar');
                Route::get('excluir/{id}', [UsuarioEnderecoController::class, 'excluir'])->name('.excluir');
            });

            Route::prefix('{user_id}/centrosDistribuicao')->name('.centrosDistribuicao')->group(function () {
                Route::get('', [CentroDistribuicaoController::class, 'inicio'])->name('');
                Route::get('criar/', [CentroDistribuicaoController::class, 'criar'])->name('.criar');
                Route::post('salvar/', [CentroDistribuicaoController::class, 'salvar'])->name('.salvar');
                Route::get('editar/{id}', [CentroDistribuicaoController::class, 'editar'])->name('.editar');
                Route::post('atualizar/{id}', [CentroDistribuicaoController::class, 'atualizar'])->name('.atualizar');
                Route::get('excluir/{id}', [CentroDistribuicaoController::class, 'excluir'])->name('.excluir');
            });
        });
    });

    Route::prefix('estoque')->name('.estoque')->group(function () {

        Route::prefix('produtos')->name('.produtos')->group(function () {
            Route::get('', [ProdutoController::class, 'inicio'])->name('');
            Route::get('criar/', [ProdutoController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [ProdutoController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [ProdutoController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [ProdutoController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [ProdutoController::class, 'excluir'])->name('.excluir');

            Route::prefix('{produto_id}/icms')->name('.icms')->group(function () {
                Route::post('adicionar/', [ICMSProdutoEstadoController::class, 'adicionar'])->name('.adicionar');
                Route::post('atualizar/', [ICMSProdutoEstadoController::class, 'atualizar'])->name('.atualizar');
                Route::get('excluir/{id}', [ICMSProdutoEstadoController::class, 'excluir'])->name('.excluir');
            });

            Route::prefix('{produto_id}/imagens')->name('.imagens')->group(function () {
                Route::post('upload/', [ProdutoImagemController::class, 'upload'])->name('.upload');
                Route::get('delete/{id}', [ProdutoImagemController::class, 'delete'])->name('.delete');
            });
        });

        Route::prefix('marcas')->name('.marcas')->group(function () {
            Route::get('', [MarcaController::class, 'inicio'])->name('');
            Route::get('criar/', [MarcaController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [MarcaController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [MarcaController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [MarcaController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [MarcaController::class, 'excluir'])->name('.excluir');
        });

        Route::prefix('categorias')->name('.categorias')->group(function () {
            Route::get('', [CategoriaController::class, 'inicio'])->name('');
            Route::get('criar/', [CategoriaController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [CategoriaController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [CategoriaController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [CategoriaController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [CategoriaController::class, 'excluir'])->name('.excluir');
        });

        Route::prefix('produto/tipos')->name('.tiposProduto')->group(function () {
            Route::get('', [TipoProdutoController::class, 'inicio'])->name('');
            Route::get('criar/', [TipoProdutoController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [TipoProdutoController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [TipoProdutoController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [TipoProdutoController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [TipoProdutoController::class, 'excluir'])->name('.excluir');

            Route::post('adicional/{id}', [TipoProdutoController::class, 'adicional'])->name('.adicional');
            Route::get('{id}/excluirAdicional/{adicional_id}', [TipoProdutoController::class, 'excluirAdicional'])->name('.excluirAdicional');
        });
    });

    Route::prefix('pedidos')->name('.pedidos')->group(function () {

        Route::prefix('listasPreco')->name('.listas_preco')->group(function () {
            Route::get('', [ListaPrecoController::class, 'inicio'])->name('');
            Route::get('criar/', [ListaPrecoController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [ListaPrecoController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [ListaPrecoController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [ListaPrecoController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [ListaPrecoController::class, 'excluir'])->name('.excluir');

            Route::prefix('{lista_preco_id}/itemListaPreco')->name('.itens')->group(function () {
                Route::get('', [ItemListaPrecoController::class, 'inicio'])->name('');
                Route::get('criar/', [ItemListaPrecoController::class, 'criar'])->name('.criar');
                Route::post('salvar/', [ItemListaPrecoController::class, 'salvar'])->name('.salvar');
                Route::get('editar/{id}', [ItemListaPrecoController::class, 'editar'])->name('.editar');
                Route::post('atualizar/{id}', [ItemListaPrecoController::class, 'atualizar'])->name('.atualizar');
                Route::get('excluir/{id}', [ItemListaPrecoController::class, 'excluir'])->name('.excluir');
            });
        });
    });
});
