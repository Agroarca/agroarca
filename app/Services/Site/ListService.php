<?php

namespace App\Services\Site;

use App\Models\Estoque\Produto;
use App\Models\Pedidos\PedidoItem;
use App\Services\Site\ProdutoService;

class ListService
{

    protected static function queryProdutoCompravel()
    {
        $query = Produto::select('produtos.*');
        return ProdutoService::produtoCompravel($query, EntregaService::getDataEntrega());
    }

    protected static function queryBaseListas()
    {
        return self::queryProdutoCompravel()
            ->with([
                'itensListaPreco' => function ($query) {
                    $query = $query->select('itens_lista_preco.*')
                        ->selectRaw('juroItemListaPreco(itens_lista_preco.id, ?) as preco_item',  [EntregaService::getDataEntrega()]);

                    ProdutoService::itemListaPrecoCompravel($query, EntregaService::getDataEntrega());
                    ProdutoService::queryItensListaPrecoOrdenadosValor($query, EntregaService::getDataEntrega());
                },
                'imagens' => fn ($query) => $query->whereIn(
                    'produto_imagens.id',
                    fn ($subQuery) => $subQuery->selectRaw('min(pi.id) from produto_imagens as pi group by pi.produto_id')
                )
            ]);
    }

    public static function queryItensAdicionaisPedido(PedidoItem $item)
    {
        return self::queryBaseListas()
            ->whereIn(
                'tipo_produto_id',
                fn ($query) => $query->selectRaw(
                    'adic.tipo_produto_adicional_id from tipos_produto_adicionais adic
                    inner join produtos p on adic.tipo_produto_id = p.tipo_produto_id
                    inner join itens_lista_preco ilp on ilp.produto_id = p.id
                    inner join pedido_itens pi on pi.item_lista_preco_id = ilp.id
                    where pi.id = ?',
                    [$item->id]
                )
            )->whereExists(function ($query) use ($item) {
                $query = $query->select('itens_lista_preco.*')
                    ->join('listas_preco', 'itens_lista_preco.lista_preco_id', '=', 'listas_preco.id')
                    ->whereColumn('itens_lista_preco.produto_id', 'produtos.id')
                    ->where('listas_preco.fornecedor_id', function ($query) use ($item) {
                        $query->select('lp.fornecedor_id')
                            ->from('listas_preco as lp')
                            ->join('itens_lista_preco', 'itens_lista_preco.lista_preco_id', '=', 'lp.id')
                            ->where('itens_lista_preco.id', $item->item_lista_preco_id);
                    });

                ProdutoService::itemListaPrecoCompravel($query, EntregaService::getDataEntrega());
            })->with([
                'itensListaPreco' => function ($query) use ($item) {
                    $query = $query->select('itens_lista_preco.*')
                        ->selectRaw('juroItemListaPreco(itens_lista_preco.id, ?) as preco_item',  [EntregaService::getDataEntrega()])
                        ->selectRaw('case when exists(select * from itens_lista_preco as ilp join pedido_itens on ilp.id = pedido_itens.item_lista_preco_id
                            where pedido_itens.pedido_item_pai_id = ? and ilp.id = itens_lista_preco.id) then true else false end as adicionado', [$item->id]);

                    ProdutoService::itemListaPrecoCompravel($query, EntregaService::getDataEntrega())
                        ->join('listas_preco', 'itens_lista_preco.lista_preco_id', '=', 'listas_preco.id')
                        ->where('listas_preco.fornecedor_id', function ($query) use ($item) {
                            $query->select('lp.fornecedor_id')
                                ->from('listas_preco as lp')
                                ->join('itens_lista_preco', 'itens_lista_preco.lista_preco_id', '=', 'lp.id')
                                ->where('itens_lista_preco.id', $item->item_lista_preco_id);
                        })
                        ->where('centro_distribuicao_id', function ($query) use ($item) {
                            $query->select('ilpc.centro_distribuicao_id')
                                ->from('itens_lista_preco as ilpc')
                                ->join('pedido_itens', 'pedido_itens.item_lista_preco_id', '=', 'ilpc.id')
                                ->where('pedido_itens.id', $item->id);
                        })->orderByRaw('juroItemListaPreco(itens_lista_preco.id, ?)', [EntregaService::getDataEntrega()]);

                    ProdutoService::queryItensListaPrecoOrdenadosValor($query, EntregaService::getDataEntrega());
                }
            ]);
    }

    public static function queryListagemProdutos()
    {
        return self::queryBaseListas()
            ->whereIn('produtos.tipo_produto_id', function ($query) {
                $query->select('tipos_produto.id')
                    ->from('tipos_produto')
                    ->where('tipos_produto.listavel', true);
            });
    }

    public static function queryListagemCategoria($categoriaId)
    {
        return self::queryListagemProdutos()
            ->whereRaw(
                "categoria_id in (
                    with recursive cats (id) as (
                        select id from categorias where (@id is null and categoria_mae_id is null) or (@id is not null and id = @id)
                        union all select cat.id from categorias cat inner join cats on cat.categoria_mae_id = cats.id)
                    select id from cats, (select @id := ?) inicializacao)",
                [$categoriaId]
            );
    }
}
