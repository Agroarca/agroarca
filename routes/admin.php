<?php

use App\Http\Controllers\Cadastros\CentroDistribuicaoController;
use App\Http\Controllers\Cadastros\CidadeController;
use App\Http\Controllers\Cadastros\EstadoController;
use App\Http\Controllers\Cadastros\UsuarioController;
use App\Http\Controllers\Cadastros\UsuarioEnderecoController;
use App\Http\Controllers\Estoque\CategoriaController;
use App\Http\Controllers\Estoque\MarcaController;
use App\Http\Controllers\Estoque\ProdutoController;
use App\Http\Controllers\Estoque\ProdutoImagemController;
use App\Http\Controllers\Estoque\TipoProdutoController;
use App\Models\Cadastros\CentroDistribuicao;
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

            Route::prefix('{user_id}/centrosDistribuicao')->name('.centrosDistribuicao')->group(function(){
                Route::get('', [CentroDistribuicaoController::class, 'inicio'])->name('');
                Route::get('criar/', [CentroDistribuicaoController::class, 'criar'])->name('.criar');
                Route::post('salvar/', [CentroDistribuicaoController::class, 'salvar'])->name('.salvar');
                Route::get('editar/{id}', [CentroDistribuicaoController::class, 'editar'])->name('.editar');
                Route::post('atualizar/{id}', [CentroDistribuicaoController::class, 'atualizar'])->name('.atualizar');
                Route::get('excluir/{id}', [CentroDistribuicaoController::class, 'excluir'])->name('.excluir');
            });
        });
    });

    Route::namespace('Estoque')->prefix('estoque')->name('.estoque')->group(function(){

        Route::prefix('produtos')->name('.produtos')->group(function (){
            Route::get('', [ProdutoController::class, 'inicio'])->name('');
            Route::get('criar/', [ProdutoController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [ProdutoController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [ProdutoController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [ProdutoController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [ProdutoController::class, 'excluir'])->name('.excluir');

            Route::prefix('{produto_id}/imagens')->name('.imagens')->group(function (){
                Route::post('upload/', [ProdutoImagemController::class, 'upload'])->name('.upload');
                Route::get('delete/{id}', [ProdutoImagemController::class, 'delete'])->name('.delete');
            });
        });

        Route::prefix('marcas')->name('.marcas')->group(function (){
            Route::get('', [MarcaController::class, 'inicio'])->name('');
            Route::get('criar/', [MarcaController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [MarcaController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [MarcaController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [MarcaController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [MarcaController::class, 'excluir'])->name('.excluir');
        });

        Route::prefix('categorias')->name('.categorias')->group(function (){
            Route::get('', [CategoriaController::class, 'inicio'])->name('');
            Route::get('criar/', [CategoriaController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [CategoriaController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [CategoriaController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [CategoriaController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [CategoriaController::class, 'excluir'])->name('.excluir');
        });

        Route::prefix('produto/tipos')->name('.tiposProduto')->group(function (){
            Route::get('', [TipoProdutoController::class, 'inicio'])->name('');
            Route::get('criar/', [TipoProdutoController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [TipoProdutoController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [TipoProdutoController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [TipoProdutoController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [TipoProdutoController::class, 'excluir'])->name('.excluir');
        });

    });
});
