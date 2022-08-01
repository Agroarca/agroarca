<?php

namespace App\Services\Site;

use App\Enums\Pedidos\ModalidadeFormaPagamento;
use App\Helpers\Formatter;
use App\Models\Cadastros\Usuario;
use App\Models\Pedidos\FormaPagamento;
use App\Models\Pedidos\Pedido;
use App\Models\Pedidos\PedidoItem;
use Illuminate\Support\Facades\Auth;

class CarrinhoService
{
    public static function getCarrinho()
    {
        $pedido = PedidoService::getPedido();
        $pedido->load([
            'pedidoItens.itemListaPreco.produto',
            'pedidoItens.itemListaPreco.produto.imagens',
            'pedidoItens.pedidoItensAdicionais',
            'pedidoItens.pedidoItensAdicionais.itemListaPreco',
            'pedidoItens.pedidoItensAdicionais.itemListaPreco.produto',
            'pedidoItens.pedidoItensAdicionais.itemListaPreco.produto.tipoProduto'
        ]);

        return [
            'pedidoItens' => self::getPedidoItens($pedido),
            'frete' => $pedido->frete,
            'subtotal' => $pedido->subtotal,
            'total' => $pedido->total,
            'finalizarPedido' => route('site.carrinho.continuar'),
            'data_pagamento' => $pedido->data_pagamento,
            'data_entrega' => $pedido->data_entrega,
        ];
    }

    public static function getPedidoItens(Pedido $pedido)
    {
        $itens = [];
        foreach ($pedido->pedidoItens as $pedidoItem) {
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
                'link_alterar_quantidade' => route('site.carrinho.alterar_quantidade', $pedidoItem->id),
                'link_adicionais' => route('site.carrinho.adicionais', $pedidoItem->id),
                'link_salvar_adicionais' => route('site.carrinho.salvar_adicionais', $pedidoItem->id),
                'tem_adicionais' => self::temAdicionais($pedidoItem)
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
            'data_pagamento' => $pedido->data_pagamento,
            'enderecos' => self::getUsuarioEnderecos(),
            'endereco_id' => $pedido->endereco_id,
            'adicionar_endereco' => route('site.carrinho.enderecos.adicionar'),
            'formas_pagamento' => self::getFormasPagamento(),
            'forma_pagamento_id' => $pedido->forma_pagamento_id,
            'alterarDataPagamento' => route('site.carrinho.alterarDataPagamento'),
            'alterarDataEntrega' => route('site.carrinho.alterarDataEntrega'),
            'finalizarPedido' => route('site.carrinho.finalizar'),
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

    public static function getFormasPagamento()
    {
        $formasPagamento = [];
        foreach (FormaPagamento::all() as $formaPagamento) {
            array_push($formasPagamento, [
                'id' => $formaPagamento->id,
                'nome' => $formaPagamento->nome,
                'tipo' => $formaPagamento->tipo,
                'modalidade' => $formaPagamento->modalidade,
                'mostrarData' => $formaPagamento->modalidade == ModalidadeFormaPagamento::Credito,
                'selecionar' => route('site.carrinho.selecionarFormaPagamento', $formaPagamento->id)
            ]);
        }

        return $formasPagamento;
    }

    private static function temAdicionais(PedidoItem $pedidoItem)
    {
        return ListService::queryItensAdicionaisPedido($pedidoItem)->count() > 0;
    }

    public static function adicionaisPedidoItem(PedidoItem $pedidoItem)
    {
        $itens = ListService::queryItensAdicionaisPedido($pedidoItem)->get();
        //return $itens;
        $adicionais = [];
        foreach ($itens as $item) {
            $itemListaPreco = self::selecionarItemListaPreco($item->itensListaPreco);
            array_push($adicionais, [
                'id' => $item->id,
                'codigo' => $item->codigo,
                'nome' => $item->nome,
                'descricao' => $item->descricao,
                'preco' => $itemListaPreco->preco_item,
                'imagem' => self::getImagem($item),
                'adicionado' => $item->adicionado,
                'item_lista_preco_id' => $itemListaPreco->id,
                'selecionado' => $itemListaPreco->selecionado
            ]);
        }

        return $adicionais;
    }

    private static function selecionarItemListaPreco($itensListaPreco)
    {
        foreach ($itensListaPreco as $item) {
            if ($item->selecionado) {
                return $item;
            }
        }

        return $itensListaPreco->first();
    }
}
