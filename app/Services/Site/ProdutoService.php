<?php

namespace App\Services\Site;

use App\Classes\Interfaces\ProdutoPreco;
use App\Models\Produtos\Produto;
use App\Services\Administracao\DominioService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProdutoService
{
    public static function getPrecosProduto(Produto $produto, $limit = null)
    {
        $cep = EntregaService::getCepEnderecoPadrao();

        $produtoPrecos = [];
        $query = $produto->itensListaPreco();
        self::itemListaPrecoCompravel($query);
        self::queryItensListaPrecoOrdenadosValor($query);
        $query->with(['centroDistribuicao']);

        $itens = $query->limit($limit ?? 1)->get();

        foreach ($itens as $item) {
            $produtoPreco = new ProdutoPreco();

            if ($cep) {
                $produtoPreco->frete_quilo = EntregaService::calcularFrete($item, $cep);
            } else {
                $produtoPreco->frete_quilo = 0;
            }

            $produtoPreco->preco_quilo = $item->calculaPreco();
            $produtoPreco->preco_total = $produtoPreco->preco_quilo + $produtoPreco->frete_quilo;
            $produtoPreco->item_lista_preco_id = $item->id;
            array_push($produtoPrecos, $produtoPreco);
        }

        return $produtoPrecos;
    }

    /*
    * A query valida a tabela itens_lista_preco (já deve estar incluida)
    */
    public static function itemListaPrecoCompravel($query)
    {
        $query
            ->join('listas_preco', 'itens_lista_preco.lista_preco_id', '=', 'listas_preco.id')
            ->where('listas_preco.dominio_id', DominioService::getDominioId())
            ->where('itens_lista_preco.preco_quilo', '>', DB::raw(0))
            ->whereRaw('sysdate() between listas_preco.data_inicio and listas_preco.data_fim');

        return $query;
    }

    /*
    * A query valida a tabela produtos (já deve estar incluida)
    */
    public static function produtoCompravel($query)
    {
        return $query
            ->whereNotNull('produtos.icms_padrao')
            ->where('produtos.quantidade_disponivel', '>', DB::raw(0))
            ->whereExists(
                function ($query) {
                    $query->select('*')
                        ->from('itens_lista_preco')
                        ->whereColumn('itens_lista_preco.produto_id', 'produtos.id');

                    self::itemListaPrecoCompravel($query);
                }
            )->whereExists(function ($query) {
                $query->select('*')
                    ->from('produto_imagens')
                    ->whereColumn('produto_id', 'produtos.id');
            })->where('produtos.dominio_id', DominioService::getDominioId());
    }

    public static function queryItensListaPrecoOrdenadosValor($query, $dataPagamento = null)
    {
        $dataPagamento = new Carbon($dataPagamento);
        $cep = EntregaService::getCepEnderecoPadrao();

        if (!$cep) {
            return $query->orderByRaw('(juroItemListaPreco(itens_lista_preco.id, ?))', [$dataPagamento]);
        }

        return $query
            ->join('centros_distribuicao', 'itens_lista_preco.centro_distribuicao_id', '=', 'centros_distribuicao.id')
            ->where('centros_distribuicao.dominio_id', DominioService::getDominioId())
            ->orderByRaw(
                '(juroItemListaPreco(itens_lista_preco.id, ?) +
                    itens_lista_preco.base_frete * distanciaGeografica(?, ?, centros_distribuicao.latitude, centros_distribuicao.longitude))',
                [$dataPagamento, $cep->latitude, $cep->longitude]
            );
    }
}
