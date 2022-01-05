<?php

namespace App\Http\Controllers\Site;

use App\Classes\Interfaces\ProdutoPreco;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frete\DistanciasController;
use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Estoque\Produto;
use App\Models\Frete\Cep;

class ProdutoPrecoController extends Controller
{
    protected $limit = 20;
    protected $freteController;

    public function __construct(){
        $this->freteController = new FreteController();
    }

    public function getPrecosProduto(Produto $produto){
        $precos = [];
        $cep = $this->freteController->getCepEnderecoPadrao();
        if($cep){
            $controller = new DistanciasController();
            $controller->verificarAtualizarPlaceId($cep);
            $itens = $this->getItensProximos($produto, $cep);

            foreach($itens as $item){
                $distancia = $controller->calcularDistancia($cep, $item->centroDistribuicao->usuarioEndereco);

                $produtoPreco = new ProdutoPreco();
                $produtoPreco->preco_quilo = $item->preco_quilo;
                $produtoPreco->frete_quilo = $item->base_frete * ($distancia / 1000);
                $produtoPreco->preco_total = $produtoPreco->preco_quilo + $produtoPreco->frete_quilo;
                $produtoPreco->item_lista_preco_id = $item->id;
                $precos[] = $produtoPreco;
            }

            if(count($precos) > 0){
                return $precos;
            }

        }

        $itens = $produto->itensListaPreco()->orderBy('preco_quilo')->limit($this->limit)->get();
        foreach($itens as $item){
            $produtoPreco = new ProdutoPreco();
            $produtoPreco->preco_quilo = $item->preco_quilo;
            $produtoPreco->item_lista_preco_id = $item->id;
            $precos[] = $produtoPreco;
        }

        return $precos;
    }

    public function getPrecoProduto(Produto $produto){
        $produtoPreco = new ProdutoPreco();
        $cep = $this->freteController->getCepEnderecoPadrao();
        if($cep){
            $controller = new DistanciasController();
            $controller->verificarAtualizarPlaceId($cep);
            $item = $this->getItemProximo($produto, $cep);

            if($item){
                $distancia = $controller->calcularDistancia($cep, $item->centroDistribuicao->usuarioEndereco);
                $produtoPreco->preco_quilo = $item->preco_quilo;
                $produtoPreco->frete_quilo = $item->base_frete * ($distancia / 1000);
                $produtoPreco->preco_total = $produtoPreco->preco_quilo + $produtoPreco->frete_quilo;
                $produtoPreco->item_lista_preco_id = $item->id;
                return $produtoPreco;
            }
        }

        $item = $produto->itensListaPreco()->orderBy('preco_quilo')->first();
        $produtoPreco->preco_quilo = $item->preco_quilo;
        $produtoPreco->item_lista_preco_id = $item->id;
        return $produtoPreco;
    }

    private function getItemProximo(Produto $produto, $cep){
        if(!$cep instanceof Cep && !$cep instanceof UsuarioEndereco){
            return null;
        }

        return $produto->itensListaPreco()
                ->where(function($query){
                    $query->whereNull('estoque_disponivel')
                        ->orWhere('estoque_disponivel', '>', 0);
                })
                ->join('fornecedor_centros_distribuicao', 'itens_lista_preco.centro_distribuicao_id', '=', 'fornecedor_centros_distribuicao.id')
                ->join('usuario_enderecos', 'fornecedor_centros_distribuicao.usuario_endereco_id', '=', 'usuario_enderecos.id')
                ->orderByRaw('(itens_lista_preco.preco_quilo + itens_lista_preco.base_frete * distanciaGeografica(?, ?, usuario_enderecos.latitude, usuario_enderecos.longitude))', [$cep->latitude, $cep->longitude])
                ->first();
    }

    private function getItensProximos(Produto $produto, $cep){
        if(!$cep instanceof Cep && !$cep instanceof UsuarioEndereco){
            return [];
        }

        return $produto->itensListaPreco()
                ->where(function($query){
                    $query->whereNull('estoque_disponivel')
                        ->orWhere('estoque_disponivel', '>', 0);
                })
                ->join('fornecedor_centros_distribuicao', 'itens_lista_preco.centro_distribuicao_id', '=', 'fornecedor_centros_distribuicao.id')
                ->join('usuario_enderecos', 'fornecedor_centros_distribuicao.usuario_endereco_id', '=', 'usuario_enderecos.id')
                ->orderByRaw('(itens_lista_preco.preco_quilo + itens_lista_preco.base_frete * distanciaGeografica(?, ?, usuario_enderecos.latitude, usuario_enderecos.longitude))', [$cep->latitude, $cep->longitude])
                ->limit($this->limit)
                ->get();
    }
}