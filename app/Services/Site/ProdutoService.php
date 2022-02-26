<?php

namespace App\Services\Site;

use App\Classes\Interfaces\ProdutoPreco;
use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Estoque\Produto;
use App\Models\Frete\Cep;
use App\Services\DistanciasService;
use Illuminate\Support\Facades\DB;

class ProdutoService
{
    public static function getPrecosProduto(Produto $produto, $limit = null)
    {
        $cep = EntregaService::getCepEnderecoPadrao();

        $produtoPrecos = [];
        $query = $produto->itensListaPreco();
        self::itemListaPrecoCompravel($query, EntregaService::getDataEntrega());
        self::queryItensListaPrecoOrdenadosValor($query, EntregaService::getDataEntrega());
        $query->with(['centroDistribuicao', 'centroDistribuicao.usuarioEndereco']);

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
    public static function itemListaPrecoCompravel($query, $dataEntrega = null)
    {
        $query
            ->join('listas_preco', 'itens_lista_preco.lista_preco_id', '=', 'listas_preco.id')
            ->where('itens_lista_preco.preco_quilo', '>', DB::raw(0))
            ->where(
                fn ($query) => $query->whereNull('estoque_disponivel')
                    ->orWhere('estoque_disponivel', '>', DB::raw(0))
            );

        if ($dataEntrega) {
            $query->whereRaw('? between listas_preco.data_inicio and listas_preco.data_fim', [$dataEntrega])
                ->where(
                    fn ($query) => $query->whereNull('itens_lista_preco.data_inicial_entrega')
                        ->orWhereDate('itens_lista_preco.data_inicial_entrega', '<', $dataEntrega)
                )->where(
                    fn ($query) => $query->whereNull('itens_lista_preco.data_final_entrega')
                        ->orWhereDate('itens_lista_preco.data_final_entrega', '>', $dataEntrega)
                )->whereRaw('sysdate() + itens_lista_preco.minimo_dias_entrega > ?', [$dataEntrega]);
        }

        return $query;
    }

    /*
    * A query valida a tabela produtos (já deve estar incluida)
    */
    public static function produtoCompravel($query, $dataEntrega = null)
    {
        return $query
            ->whereNotNull('produtos.icms_padrao')
            ->whereExists(
                function ($query) use ($dataEntrega) {
                    $query->select('*')
                        ->from('itens_lista_preco')
                        ->whereColumn('itens_lista_preco.produto_id', 'produtos.id');

                    self::itemListaPrecoCompravel($query, $dataEntrega);
                }
            )->whereExists(function ($query) {
                $query->select('*')
                    ->from('produto_imagens')
                    ->whereColumn('produto_id', 'produtos.id');
            });
    }

    public static function queryItensListaPrecoOrdenadosValor($query, $dataEntrega)
    {
        $cep = EntregaService::getCepEnderecoPadrao();

        if (!$cep) {
            return $query->orderByRaw('(juroItemListaPreco(itens_lista_preco.id, ?))', $dataEntrega);
        }

        return $query
            ->join('fornecedor_centros_distribuicao', 'itens_lista_preco.centro_distribuicao_id', '=', 'fornecedor_centros_distribuicao.id')
            ->join('usuario_enderecos', 'fornecedor_centros_distribuicao.usuario_endereco_id', '=', 'usuario_enderecos.id')
            ->orderByRaw(
                '(juroItemListaPreco(itens_lista_preco.id, ?) +
                    itens_lista_preco.base_frete * distanciaGeografica(?, ?, usuario_enderecos.latitude, usuario_enderecos.longitude))',
                [$dataEntrega, $cep->latitude, $cep->longitude]
            );
    }
}
