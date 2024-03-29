<?php

use App\Http\Controllers\Admin\Administracao\AdministradorController;
use App\Http\Controllers\Admin\Administracao\DominioController;
use App\Http\Controllers\Admin\Cadastros\CentroDistribuicaoController;
use App\Http\Controllers\Admin\Cadastros\CidadeController;
use App\Http\Controllers\Admin\Cadastros\EstadoController;
use App\Http\Controllers\Admin\Cadastros\UsuarioController;
use App\Http\Controllers\Admin\Cadastros\UsuarioEnderecoController;
use App\Http\Controllers\Admin\Estoque\Lotes\LoteController;
use App\Http\Controllers\Admin\Produtos\CategoriaController;
use App\Http\Controllers\Admin\Produtos\ICMSProdutoEstadoController;
use App\Http\Controllers\Admin\Produtos\MarcaController;
use App\Http\Controllers\Admin\Produtos\ProdutoController;
use App\Http\Controllers\Admin\Produtos\ProdutoImagemController;
use App\Http\Controllers\Admin\Produtos\TipoProdutoController;
use App\Http\Controllers\Admin\PainelController;
use App\Http\Controllers\Admin\Pedidos\FormaPagamentoController;
use App\Http\Controllers\Admin\Pedidos\ItemListaPrecoController;
use App\Http\Controllers\Admin\Pedidos\ListaPrecoController;
use App\Http\Controllers\Admin\Pedidos\PedidoController;
use App\Http\Controllers\Admin\Pedidos\PedidoItemController;
use App\Http\Controllers\Admin\Pedidos\PedidoItemLoteController;
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

    Route::prefix('administracao')->name('.administracao')->group(function () {
        Route::prefix('dominios')->name('.dominios')->group(function () {
            Route::get('', [DominioController::class, 'inicio'])->name('');
            Route::get('criar/', [DominioController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [DominioController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [DominioController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [DominioController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [DominioController::class, 'excluir'])->name('.excluir');
        });

        Route::prefix('administradores')->name('.administradores')->group(function () {
            Route::get('', [AdministradorController::class, 'inicio'])->name('');
        });
    });

    Route::prefix('cadastros')->name('.cadastros')->group(function () {
        Route::prefix('centrosDistribuicao')->name('.centrosDistribuicao')->group(function () {
            Route::get('', [CentroDistribuicaoController::class, 'inicio'])->name('');
            Route::get('criar/', [CentroDistribuicaoController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [CentroDistribuicaoController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [CentroDistribuicaoController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [CentroDistribuicaoController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [CentroDistribuicaoController::class, 'excluir'])->name('.excluir');
        });

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
            Route::get('admin/{id}', [UsuarioController::class, 'admin'])->name('.admin');

            Route::prefix('{userId}/enderecos')->name('.enderecos')->group(function () {
                Route::get('criar/', [UsuarioEnderecoController::class, 'criar'])->name('.criar');
                Route::post('salvar/', [UsuarioEnderecoController::class, 'salvar'])->name('.salvar');
                Route::get('editar/{id}', [UsuarioEnderecoController::class, 'editar'])->name('.editar');
                Route::post('atualizar/{id}', [UsuarioEnderecoController::class, 'atualizar'])->name('.atualizar');
                Route::get('excluir/{id}', [UsuarioEnderecoController::class, 'excluir'])->name('.excluir');
            });
        });
    });

    Route::prefix('produtos')->name('.produtos')->group(function () {

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

            Route::get('itemListaPreco', [ItemListaPrecoController::class, 'inicio'])->name('.item');
            Route::prefix('{lista_preco_id?}/itemListaPreco')->name('.itens')->group(function () {
                Route::get('', [ItemListaPrecoController::class, 'inicio'])->name('');
                Route::get('criar/', [ItemListaPrecoController::class, 'criar'])->name('.criar');
                Route::post('salvar/', [ItemListaPrecoController::class, 'salvar'])->name('.salvar');
                Route::get('editar/{id}', [ItemListaPrecoController::class, 'editar'])->name('.editar');
                Route::post('atualizar/{id}', [ItemListaPrecoController::class, 'atualizar'])->name('.atualizar');
                Route::get('excluir/{id}', [ItemListaPrecoController::class, 'excluir'])->name('.excluir');
            });
        });

        Route::prefix('formasPagamento')->name('.formas_pagamento')->group(function () {
            Route::get('', [FormaPagamentoController::class, 'inicio'])->name('');
            Route::get('criar/', [FormaPagamentoController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [FormaPagamentoController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [FormaPagamentoController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [FormaPagamentoController::class, 'atualizar'])->name('.atualizar');
            Route::get('excluir/{id}', [FormaPagamentoController::class, 'excluir'])->name('.excluir');
        });

        Route::prefix('pedidos')->name('.pedidos')->group(function () {
            Route::get('', [PedidoController::class, 'inicio'])->name('');
            Route::get('criar/', [PedidoController::class, 'criar'])->name('.criar');
            Route::post('salvar/', [PedidoController::class, 'salvar'])->name('.salvar');
            Route::get('editar/{id}', [PedidoController::class, 'editar'])->name('.editar');
            Route::post('atualizar/{id}', [PedidoController::class, 'atualizar'])->name('.atualizar');
            Route::get('aprovar/{id}', [PedidoController::class, 'aprovarPedido'])->name('.aprovar');
            Route::get('submeter/{id}', [PedidoController::class, 'submeterPedido'])->name('.submeter');
            Route::get('excluir/{id}', [PedidoController::class, 'excluir'])->name('.excluir');
            Route::get('cancelar/{id}', [PedidoController::class, 'cancelar'])->name('.cancelar');

            Route::prefix('{pedido_id}/itens')->name('.itens')->group(function () {
                Route::post('adicionar', [PedidoItemController::class, 'adicionar'])->name('.adicionar');
                Route::post('atualizar/{id}', [PedidoItemController::class, 'atualizar'])->name('.atualizar');
                Route::post('excluir/{id}', [PedidoItemController::class, 'excluir'])->name('.excluir');

                Route::prefix('lotes')->name('.lotes')->group(function () {
                    Route::get('', [PedidoItemLoteController::class, 'inicio'])->name('');
                    Route::get('criar', [PedidoItemLoteController::class, 'criarLote'])->name('.criar');
                    Route::post('salvar', [PedidoItemLoteController::class, 'salvarLote'])->name('.salvar');
                    Route::post('/movimento/salvar', [PedidoItemLoteController::class, 'salvarMovimento'])->name('.movimento.salvar');
                });
            });
        });
    });

    Route::prefix('estoque')->name('.estoque')->group(function () {
        Route::prefix('lotes')->name('.lotes')->group(function () {
            Route::get('{produto_id?}', [LoteController::class, 'inicio'])->name('');
            Route::get('{produto_id}/criar/', [LoteController::class, 'criar'])->name('.criar');
            Route::post('{produto_id}/salvar/', [LoteController::class, 'salvar'])->name('.salvar');
            Route::get('{produto_id}/editar/{id}', [LoteController::class, 'editar'])->name('.editar');
            Route::post('{produto_id}/atualizar/{id}', [LoteController::class, 'atualizar'])->name('.atualizar');
            Route::get('{produto_id}/excluir/{id}', [LoteController::class, 'excluir'])->name('.excluir');
        });
    });
});
