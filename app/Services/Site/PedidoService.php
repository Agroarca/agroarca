<?php

namespace App\Services\Site;

use App\Enums\Pedidos\ModalidadeFormaPagamento;
use App\Enums\Pedidos\StatusPedido;
use App\Enums\Pedidos\TipoPedido;
use App\Events\Site\CarrinhoAlteradoEvent;
use App\Exceptions\EstoqueIndisponivelException;
use App\Exceptions\OperacaoIlegalException;
use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Estoque\ReservaProduto;
use App\Models\Pedidos\ItemListaPreco;
use App\Models\Pedidos\Pedido;
use App\Models\Pedidos\PedidoItem;
use App\Rules\ExistsDominio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PedidoService
{
    public static function getPedido()
    {
        $pedido = Pedido::find(session('pedidoId', null));
        if ($pedido && $pedido->status == StatusPedido::Aberto) {
            return $pedido;
        }

        if (Auth::check()) {
            $pedido = Pedido::firstOrCreate([
                'status' => StatusPedido::Aberto,
                'usuario_id' => Auth::id()
            ]);
        } else {
            $pedido = Pedido::create();
        }

        session(['pedidoId' => $pedido->id]);
        return $pedido;
    }

    public static function verificarPedidoLogin()
    {
        $pedido = Pedido::find(session('pedidoId', null));
        if ($pedido && $pedido->pedidoItens()->count() > 0) {
            if ($pedido->status == StatusPedido::Aberto) {
                $pedido->usuario_id = Auth::id();
                $pedido->save();
            }
            return;
        }

        $pedido = Pedido::orderBy('id', 'desc')->firstOrCreate([
            'status' => StatusPedido::Aberto,
            'usuario_id' => Auth::id()
        ]);

        session(['pedidoId' => $pedido->id]);

        EntregaService::verificarEnderecoLogin();

        CarrinhoAlteradoEvent::dispatch($pedido);
    }

    public static function deletePedido(Pedido $pedido)
    {
        if ($pedido->status != StatusPedido::Aberto) {
            throw new OperacaoIlegalException("Não é permitido excluir um pedido que não esteja aberto");
        }

        foreach ($pedido->pedidoItens()->cursor() as $pedidoItem) {
            $pedidoItem->pedidoItensAdicionais()->delete();
            $pedidoItem->delete();
        }

        $pedido->delete();
        CarrinhoAlteradoEvent::dispatch($pedido);
    }

    public static function adicionarItem(ItemListaPreco $item, $quantidade)
    {
        $pedido = self::getPedido();

        $pedidoItem = PedidoItem::create([
            'pedido_id' => $pedido->id,
            'item_lista_preco_id' => $item->id
        ]);

        $pedidoItem->preco_quilo = $item->calculaPreco();
        $pedidoItem->quantidade += $quantidade;
        $pedidoItem->save();

        CarrinhoAlteradoEvent::dispatch();
        return $pedidoItem;
    }

    public static function removerItem(PedidoItem $pedidoItem)
    {
        $pedido = self::getPedido();

        if ($pedido->status != StatusPedido::Aberto) {
            throw new OperacaoIlegalException("Não é permitido excluir um item de um pedido que não esteja aberto");
        }

        if ($pedido->id == $pedidoItem->pedido_id) {
            $pedidoItem->pedidoItensAdicionais()->delete();
            $pedidoItem->delete();

            CarrinhoAlteradoEvent::dispatch();
        }
    }

    public static function redirecionarAdicionais(ItemListaPreco $item)
    {
        $tipo = $item->produto->tipoProduto;
        return ($tipo->tiposProdutosAdicionais()->count() > 0);
    }

    public static function adicionarItemAdicional(PedidoItem $pedidoItem, ItemListaPreco $itemAdicional)
    {
        $pedidoItemAdicional = PedidoItem::firstOrCreate([
            'pedido_item_pai_id' => $pedidoItem->id,
            'pedido_id' => $pedidoItem->pedido_id,
            'item_lista_preco_id' => $itemAdicional->id
        ]);

        $pedidoItemAdicional->preco_quilo = $itemAdicional->calculaPreco();
        $pedidoItemAdicional->quantidade = $pedidoItem->quantidade;
        $pedidoItemAdicional->save();

        CarrinhoAlteradoEvent::dispatch();
        return $pedidoItemAdicional;
    }

    public static function removerAdicionaisExceto(PedidoItem $pedidoItem, array $adicionais)
    {
        if ($pedidoItem->pedido->status != StatusPedido::Aberto) {
            throw new OperacaoIlegalException("Não é permitido excluir um item de um pedido que não esteja aberto");
        }

        $itens = $pedidoItem
            ->pedidoItensAdicionais()
            ->whereNotIn('pedido_itens.id', function ($query) use ($pedidoItem, $adicionais) {
                $query->select('pi.id')
                    ->from('pedido_itens as pi')
                    ->join('itens_lista_preco', 'itens_lista_preco.id', '=', 'pi.item_lista_preco_id')
                    ->where('pi.pedido_item_pai_id', $pedidoItem->id)
                    ->whereIn('itens_lista_preco.id', $adicionais);
            })->get();

        if (count($itens) > 0) {
            foreach ($itens as $item) {
                $item->delete();
            }

            CarrinhoAlteradoEvent::dispatch();
        }
    }

    public static function calcularPedido(Pedido $pedido = null)
    {
        if (is_null($pedido)) {
            $pedido = self::getPedido();
        }

        $itens = $pedido->pedidoItens;
        foreach ($itens as $item) {
            self::calcularPedidoItem($item);
        }

        $pedidoItens = $pedido->pedidoItens;

        $pedido->subtotal = $pedidoItens->sum('total');
        $pedido->frete = $pedidoItens->sum('frete');
        $pedido->icms = $pedidoItens->sum('icms');
        $pedido->total = $pedido->subtotal + $pedido->frete;
        $pedido->save();
    }

    public static function calcularPedidoItem(PedidoItem $pedidoItem)
    {
        $tipoPedido = $pedidoItem->pedido->tipo;
        foreach ($pedidoItem->pedidoItensAdicionais() as $item) {
            self::calcularPedidoItem($item);
        }

        if ($pedidoItem->pedido_item_pai_id) {
            $pedidoItem->quantidade = $pedidoItem->pedidoItemPai->quantidade;
        }

        if ($pedidoItem->pedido->status == StatusPedido::Aberto) {

            $endCepEntrega = $pedidoItem->pedido->endereco;
            if (is_null($endCepEntrega) && $tipoPedido == TipoPedido::VendaEcommerce) {
                $endCepEntrega = EntregaService::getCepEnderecoPadrao();
            }

            if ($tipoPedido != TipoPedido::Compra) {
                if (!is_null($endCepEntrega)) {
                    $pedidoItem->frete = EntregaService::calcularFrete($pedidoItem->itemListaPreco, $endCepEntrega);
                } else {
                    $pedidoItem->frete = 0;
                }

                $pedidoItem->preco_quilo = $pedidoItem->itemListaPreco->calculaPreco();
            }

            $pedidoItem->frete += $pedidoItem->pedidoItensAdicionais()->sum('frete');
        }

        if ($tipoPedido != TipoPedido::Compra) {
            $pedidoItem->icms = self::calcularIcmsPedidoItem($pedidoItem);
            $pedidoItem->icms += $pedidoItem->pedidoItensAdicionais()->sum('icms');
        }

        $pedidoItem->subtotal = $pedidoItem->preco_quilo * $pedidoItem->quantidade;

        $pedidoItem->total = $pedidoItem->subtotal + $pedidoItem->ajuste;
        $pedidoItem->total += $pedidoItem->pedidoItensAdicionais()->sum('total');
        $pedidoItem->save();
    }

    public static function calcularIcmsPedidoItem(PedidoItem $pedidoItem)
    {
        $cep = EntregaService::getCepEnderecoPadrao();
        if (!$cep instanceof UsuarioEndereco) {
            return;
        }

        $estadoOrigemId = $pedidoItem->itemListaPreco->centroDistribuicao->cidade->estado_id;
        $estadoDestinoId = $cep->cidade->estado_id;

        if ($estadoOrigemId == $estadoDestinoId) {
            return 0;
        }

        $icms = $pedidoItem->itemListaPreco->produto->icmsEstado()->where('estado_id', $estadoDestinoId)->first();

        if ($icms) {
            $valorIcms = $icms->icms;
        }

        $valorIcms = $pedidoItem->itemListaPreco->produto->icms_padrao;

        return ($pedidoItem->subtotal * $valorIcms) / 100;
    }

    public static function atualizarQuantidadeCarrinho(Pedido $pedido = null)
    {
        if (is_null($pedido)) {
            $pedido = self::getPedido();
        }

        $quantidade = $pedido->pedidoItens()->count();
        session(['quantidade_carrinho' => $quantidade]);
    }

    public static function submeterPedido(Pedido $pedido)
    {
        if (is_null($pedido)) {
            $pedido = self::getPedido();
        }

        DB::transaction(function () use ($pedido) {
            $pedido->load([
                'pedidoItens',
                'pedidoItens.itemListaPreco',
                'pedidoItens.itemListaPreco.produto',
            ]);

            if ($pedido->status != StatusPedido::Aberto) {
                throw new OperacaoIlegalException("Não é permitido finalizar um pedido que não esteja aberto");
            }

            if ($pedido->pedidoItens->count() == 0) {
                throw new OperacaoIlegalException("Não é permitido finalizar um pedido sem itens");
            }

            self::calcularPedido($pedido);

            foreach ($pedido->pedidoItens as $item) {
                self::submeterPedidoItem($item);
            }

            $pedido->status = StatusPedido::Analise;
            $pedido->save();
        });
    }

    public static function submeterPedidoItem(PedidoItem $pedidoItem)
    {
        if ($pedidoItem->pedido->tipo == TipoPedido::Compra) {
            //não reserva estoque
            return;
        }

        DB::transaction(function () use ($pedidoItem) {
            if ($pedidoItem->quantidade > $pedidoItem->itemListaPreco->produto->quantidade_disponivel) {
                throw new EstoqueIndisponivelException("O produto {$pedidoItem->itemListaPreco->produto->nome} não possui quantidade suficiente em estoque");
            }

            ReservaProduto::create([
                'quantidade' => $pedidoItem->quantidade,
                'produto_id' => $pedidoItem->itemListaPreco->produto_id,
                'pedido_item_id' => $pedidoItem->id,
            ]);

            $pedidoItem->save();
            $pedidoItem->itemListaPreco->produto->atualizarQuantidade();
        });
    }

    public static function verificarEnderecoPadrao(Pedido $pedido = null)
    {
        if (is_null($pedido)) {
            $pedido = self::getPedido();
        }

        if (is_null($pedido->endereco_id)) {
            $endereco = EntregaService::getCepEnderecoPadrao();
            if (!is_null($endereco) && $endereco instanceof UsuarioEndereco) {
                $pedido->endereco_id = $endereco->id;
                $pedido->save();
            }
        }
    }

    public static function validatorPedido(Pedido $pedido)
    {
        if (is_null($pedido)) {
            $pedido = self::getPedido();
        }

        $validator = Validator::make([
            'data_entrega' => $pedido->data_entrega,
            'endereco_id' => $pedido->endereco_id,
            'forma_pagamento_id' => $pedido->forma_pagamento_id,
            'data_pagamento' => $pedido->data_pagamento
        ], [
            'data_entrega' => 'required|date',
            'endereco_id' => ['required'],
            'forma_pagamento_id' => ['required', new ExistsDominio('formas_pagamento')],
            'data_pagamento' => ['nullable', Rule::requiredIf(function () use ($pedido) {
                if (!is_null($pedido->formaPagamento)) {
                    return $pedido->formaPagamento->modalidade == ModalidadeFormaPagamento::Credito;
                }
                return false;
            }), 'date']
        ], [], [
            'data_entrega' => 'Data de Entrega',
            'endereco_id' => 'Endereço de Entrega',
            'forma_pagamento_id' => 'Forma de Pagamento',
            'data_pagamento' => 'Data de Pagamento'
        ]);

        return $validator;
    }
}
