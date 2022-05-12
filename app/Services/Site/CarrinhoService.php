<?php

namespace App\Services\Site;

use App\Helpers\Formatter;

class CarrinhoService
{
    public static function getCarrinho()
    {
        $pedido = PedidoService::getPedido();
        return [
            'pedidoItens' => self::getPedidoItens(),
            'frete' => $pedido->frete,
            'subtotal' => $pedido->subtotal,
            'total' => $pedido->total
        ];
    }

    public static function getPedidoItens()
    {
        $pedido = PedidoService::getPedido();
        $pedidoItens = $pedido->pedidoItens()
            ->whereNull('pedido_item_pai_id')
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
}
