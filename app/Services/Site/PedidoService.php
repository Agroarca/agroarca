<?php

namespace App\Services\Site;

use App\Enums\Pedidos\StatusPedido;
use App\Events\Pedido\AddPedidoItem;
use App\Events\Pedido\RemovePedidoItem;
use App\Exceptions\OperacaoIlegalException;
use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Pedidos\ItemListaPreco;
use App\Models\Pedidos\Pedido;
use App\Models\Pedidos\PedidoItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PedidoService
{

    public static function getPedido()
    {
        $pedido = Pedido::find(session('pedidoId', null));
        if ($pedido) {
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
    }

    public static function adicionarItem(ItemListaPreco $item)
    {
        $pedido = self::getPedido();

        $pedidoItem = PedidoItem::create([
            'pedido_id' => $pedido->id,
            'item_lista_preco_id' => $item->id
        ]);

        $pedidoItem->preco_quilo = $item->calculaPreco();
        $pedidoItem->save();

        AddPedidoItem::dispatch($pedidoItem);

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

            RemovePedidoItem::dispatch();
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

        AddPedidoItem::dispatch($pedidoItemAdicional);

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

            RemovePedidoItem::dispatch();
        }
    }

    public static function calcularPedido(Pedido $pedido = null)
    {
        if (is_null($pedido)) {
            $pedido = self::getPedido();
        }

        $itens = $pedido->pedidoItens()->whereNull('pedido_item_pai_id')->all();
        foreach ($itens as $item) {
            self::calcularPedidoItem($item);
        }

        $pedidoItens = $pedido->pedidoItens()->whereNull('pedido_item_pai_id');

        $pedido->subtotal = $pedidoItens->sum('total');
        $pedido->frete = $pedidoItens->sum('frete');
        $pedido->icms = $pedidoItens->sum('icms');
        $pedido->total = $pedido->subtotal + $pedido->frete;
    }

    public static function calcularPedidoItem(PedidoItem $pedidoItem)
    {
        foreach ($pedidoItem->pedidoItensAdicionais() as $item) {
            self::calcularPedidoItem($item);
        }

        if ($pedidoItem->pedido_item_pai_id) {
            $pedidoItem->quantidade = $pedidoItem->pedidoItemPai->quantidade;
        }

        if ($pedidoItem->pedido->status == StatusPedido::Aberto) {
            $dataEntrega = EntregaService::getDataEntrega();
            $pedidoItem->preco_quilo = $pedidoItem->itemListaPreco->calculaPreco($dataEntrega);

            $cepEntrega = EntregaService::getCepEnderecoPadrao();
            $pedidoItem->frete = EntregaService::calcularFrete($pedidoItem->itemListaPreco, $cepEntrega);
            $pedidoItem->frete += $pedidoItem->pedidoItensAdicionais()->sum('frete');
        }

        $pedidoItem->subtotal = $pedidoItem->preco_quilo * $pedidoItem->quantidade;
        $pedidoItem->icms = self::calcularIcmsPedidoItem($pedidoItem);
        $pedidoItem->icms += $pedidoItem->pedidoItensAdicionais()->sum('icms');

        $pedidoItem->total = $pedidoItem->subtotal + $pedidoItem->ajuste;
        $pedidoItem->total += $pedidoItem->pedidoItensAdicionais()->sum('total');
    }

    public static function calcularIcmsPedidoItem(PedidoItem $pedidoItem)
    {
        $cep = EntregaService::getCepEnderecoPadrao();
        if (!$cep instanceof UsuarioEndereco) {
            return;
        }

        $estadoOrigemId = $pedidoItem->itemListaPreco->centroDistribuicao->usuarioEndereco->cidade->estado_id;
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

    public static function getDataPagamento()
    {
        return Carbon::now()->addDays(10);
    }
}
