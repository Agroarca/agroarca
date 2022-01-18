<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Estoque\Produto;
use Illuminate\Support\Facades\DB;

class ListagemController extends Controller
{
    protected $perPage = 20;

    public function queryBase(){
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
                    ->where(function($query){
                        $query->whereNull('estoque_disponivel')
                            ->orWhere('estoque_disponivel', '>', DB::raw(0));
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
