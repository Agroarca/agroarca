<?php

namespace App\Services\Site;

use App\Helpers\Formatter;
use App\Models\Cadastros\Usuario;
use Illuminate\Support\Facades\Auth;

class CarrinhoService
{
    public static function getCarrinho()
    {
        $pedido = PedidoService::getPedido();
        return [
            'pedidoItens' => self::getPedidoItens(),
            'frete' => $pedido->frete,
            'subtotal' => $pedido->subtotal,
            'total' => $pedido->total,
            'finalizarPedido' => route('site.carrinho.continuar'),
        ];
    }

    public static function getPedidoItens()
    {
        $pedido = PedidoService::getPedido();
        $pedidoItens = $pedido->pedidoItens()
            ->with([
                'itemListaPreco.produto',
                'itemListaPreco.produto.imagens',
                'pedidoItensAdicionais',
                'pedidoItensAdicionais.itemListaPreco',
                'pedidoItensAdicionais.itemListaPreco.produto',
                'pedidoItensAdicionais.itemListaPreco.produto.tipoProduto'
            ])
            ->get();

        $itens = [];
        foreach ($pedidoItens as $pedidoItem) {
            array_push($itens, [
                'id' => $pedidoItem->id,
                'nomeProduto' => $pedidoItem->itemListaPreco->produto->nome,
                'imagem' => self::getImagem($pedidoItem->itemListaPreco->produto),
                'preco' => Formatter::preco($pedidoItem->itemListaPreco->calculaPreco()),
                'preco_unidade' => Formatter::preco($pedidoItem->itemListaPreco->preco_quilo),
                'unidade' => 'Kg.',
                'quantidade' => $pedidoItem->quantidade,
                'link_remover' => route('site.carrinho.remover', $pedidoItem->id),
                'pedidoItensAdicionais' => self::getAdicionais($pedidoItem),
                'link_alterar_quantidade' => route('site.carrinho.alterar_quantidade', $pedidoItem->id)
            ]);
        }

        return $itens;
    }

    private static function getAdicionais($pedidoItem)
    {
        $itens = [];
        foreach ($pedidoItem->pedidoItensAdicionais as $item) {

            $id = $item->itemListaPreco->produto->tipoProduto->id;
            if (!array_key_exists($id, $itens)) {
                $itens[$id]['tipo'] = $item->itemListaPreco->produto->tipoProduto->nome;
                $itens[$id]['itens'] = [];
            }

            array_push($itens[$id]['itens'], [
                'nomeProduto' => $item->itemListaPreco->produto->nome,
            ]);
        }
        return $itens;
    }

    private static function getImagem($produto)
    {
        return [
            'src' => asset("storage/produtos/{$produto->imagens[0]->nome_arquivo}"),
            'descricao' => $produto->imagens[0]->descricao
        ];
    }

    public static function getQuantidadeItens()
    {
        return session('quantidade_carrinho', 0);
    }

    public static function getDadosPedidoFinalizacao()
    {
        $pedido = PedidoService::getPedido();

        return [
            'data_entrega' => $pedido->data_entrega,
            'enderecos' => self::getUsuarioEnderecos(),
            'endereco_id' => $pedido->endereco_id,
            'adicionar_endereco' => route('site.carrinho.enderecos.adicionar'),
        ];
    }

    public static function getUsuarioEnderecos()
    {
        $enderecos = [];
        $usuario = Usuario::findOrFail(Auth::id());

        foreach ($usuario->enderecos as $endereco) {
            array_push($enderecos, [
                'id' => $endereco->id,
                'nome' => $endereco->nome,
                'endereco' => $endereco->endereco,
                'bairro' => $endereco->bairro,
                'complemento' => $endereco->complemento,
                'numero' => $endereco->numero,
                'cep' => $endereco->cep,
                'cidade' => $endereco->cidade->nome,
                'uf' => $endereco->cidade->estado->uf,
                'excluir' => route('site.carrinho.enderecos.excluir', $endereco->id),
                'selecionar' => route('site.carrinho.enderecos.selecionar', $endereco->id)
            ]);
        }

        return $enderecos;
    }
}
