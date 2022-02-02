<?php

namespace App\Services\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\ListagemController;
use App\Models\Estoque\Categoria;
use App\Models\Estoque\Produto;
use Illuminate\Support\Facades\DB;

class ListService
{
    protected $productModel;
    protected $categoryModel;

    /**
     * Class constructor
     *
     * @param Produto $productModel
     * @param Categoria $categoryModel
     */
    public function __construct(Produto $productModel, Categoria $categoryModel)
    {
        $this->productModel = $productModel;
        $this->categoryModel = $categoryModel;
    }

    /**
     * Returns a query instance to be used as base.
     *
     * @return void
     */
    public static function queryBase()
    {
        // seleciona todos os produtos que estão cadastrados em listas de preço,
        // possuem estoque e tem preço maior que 0
        return Produto::whereExists(
            function ($query) {
                $query->select(DB::raw(1))
                    ->from('itens_lista_preco')
                    ->join('listas_preco', 'itens_lista_preco.lista_preco_id', '=', 'listas_preco.id')
                    ->whereColumn('itens_lista_preco.produto_id', 'produtos.id')
                    ->where('preco_quilo', '>', DB::raw(0))
                    ->whereRaw('sysdate() between listas_preco.data_inicio and listas_preco.data_fim')
                    ->where(function ($query) {
                        $query->whereNull('estoque_disponivel')
                            ->orWhere('estoque_disponivel', '>', DB::raw(0));
                    });

                //retorna junto os itens de lista de preço com menor valor
            }
        )->with(['itensListaPreco' => function ($query) {
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
        }]);
    }

    /**
     * Returns category by given id.
     *
     * @param integer|null $id
     * @return Categoria|null
     */
    public function findCategoryById(?int $id) : ?Categoria
    {
        return $this->categoryModel->find($id);
    }

    /**
     * Returns all categories mother's by id, with a recursive procedure by eduardo.
     *
     * @param integer|null $id
     * @return void
     */
    public function getAllChildCategories(?int $id)
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
