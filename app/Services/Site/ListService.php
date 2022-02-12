<?php

namespace App\Services\Site;

use App\Models\Estoque\Categoria;
use App\Models\Estoque\Produto;
use App\Models\Pedidos\PedidoItem;
use Illuminate\Support\Facades\DB;

class ListService
{
    public static function queryBase()
    {
        // seleciona todos os produtos que estão cadastrados em listas de preço,
        // possuem estoque e tem preço maior que 0
        return Produto::select('produtos.*')
            ->whereExists(
                function ($query) {
                    $query->select('*')
                        ->from('itens_lista_preco')
                        ->join('listas_preco', 'itens_lista_preco.lista_preco_id', '=', 'listas_preco.id')
                        ->whereColumn('itens_lista_preco.produto_id', 'produtos.id')
                        ->where('preco_quilo', '>', 0)
                        ->whereRaw('sysdate() between listas_preco.data_inicio and listas_preco.data_fim')
                        ->where(function ($query) {
                            $query->whereNull('estoque_disponivel')
                                ->orWhere('estoque_disponivel', '>', 0);
                        });

                    //retorna junto os itens de lista de preço com menor valor
                }
            )->with([
                'itensListaPreco' => function ($query) {
                    $query->where('itens_lista_preco.preco_quilo', function ($subQuery) {
                        $subQuery->selectRaw('min(i2.preco_quilo)')
                            ->from('itens_lista_preco as i2')
                            ->whereColumn('i2.produto_id', 'itens_lista_preco.produto_id');
                    });
                },
                'imagens' => function ($query) {
                    $query->whereIn('produto_imagens.id', function ($subQuery) {
                        $subQuery->selectRaw('min(pi.id) from produto_imagens as pi group by pi.produto_id');
                    });
                }
            ]);
    }

    public static function queryItensAdicionaisPedido(PedidoItem $item)
    {
        return self::queryBase()
            ->whereIn('tipo_produto_id', function ($query) use ($item) {
                $query->selectRaw(
                    'adic.tipo_produto_adicional_id
                    from tipos_produto_adicionais adic
                    inner join produtos p on adic.tipo_produto_id = p.tipo_produto_id
                    inner join itens_lista_preco ilp on ilp.produto_id = p.id
                    inner join pedido_itens pi on pi.item_lista_preco_id = ilp.id
                    where pi.id = ?',
                    [$item->id]
                );
            });
    }

    public static function queryListarProdutos()
    {
        return self::queryBase()
            ->join('tipos_produto', 'tipos_produto.id', '=', 'produtos.tipo_produto_id')
            ->where('tipos_produto.listavel', true);
    }

    /**
     * Returns all categories mother's by id, with a recursive procedure by eduardo.
     *
     * @param integer|null $id
     * @return void
     */
    public static function getAllChildCategories(?int $id)
    {
        $categorias = DB::select('
            with recursive cats (id) as (
                select id
                from categorias
                where (
                    @id is null
                    and categoria_mae_id is null
                ) or (
                    @id is not null
                    and id = @id
                )
                union all
                select cat.id
                from categorias cat
                inner join cats on cat.categoria_mae_id = cats.id
            )
            select id from cats,
            (select @id := ?) inicializacao;', [$id]);

        return collect($categorias)->pluck('id');
    }
}
