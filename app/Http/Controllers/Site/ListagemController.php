<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Estoque\Produto;
use Illuminate\Support\Facades\DB;

class ListagemController extends Controller
{
    protected $perPage = 20;

    protected function queryBase(){
        // seleciona todos os produtos que estão cadastrados em listas de preço,
        // possuem estoque e tem preço maior que 0
        return Produto::whereExists(
            function ($query) {
                $query->select(DB::raw(1))
                    ->from('itens_lista_preco')
                    ->whereColumn('itens_lista_preco.produto_id', 'produtos.id')
                    ->where('preco_quilo', '>', 0)
                    ->where(function($query){
                        $query->whereNull('estoque_disponivel')
                            ->orWhere('estoque_disponivel', '>', 0);
                    });

        //retorna junto os itens de lista de preço com menor valor
        })->with(['itensListaPreco' => function($query) {
            $query->where('itens_lista_preco.preco_quilo', function($subQuery){
                $subQuery->selectRaw('min(i2.preco_quilo)')
                        ->from('itens_lista_preco as i2')
                        ->whereColumn('i2.produto_id', 'itens_lista_preco.produto_id');
            });
        }]);
    }
}
