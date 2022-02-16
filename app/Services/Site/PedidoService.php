<?php

namespace App\Services\Site;

use App\Enums\Pedidos\StatusPedido;
use App\Events\Pedido\AddPedidoItem;
use App\Events\Pedido\RemovePedidoItem;
use App\Exceptions\OperacaoIlegalException;
use App\Models\Pedidos\ItemListaPreco;
use App\Models\Pedidos\Pedido;
use App\Models\Pedidos\PedidoItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PedidoService
{

    public static function getPedido()
    {
        $pedido = self::getPedidoCookie();
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

        self::setPedidoCookie($pedido);
        return $pedido;
    }

    private static function getPedidoCookie()
    {
        $pedidoId = Cookie::get('pedidoId');

        $pedido = Pedido::find($pedidoId);
        if ($pedido) {
            $usuarioId = Auth::id();
            if ($pedido->usuario_id == $usuarioId) {
                return $pedido;
            }
        }

        return null;
    }

    private static function setPedidoCookie(Pedido $pedido)
    {
        $pedidoId = Cookie::get('pedidoId');
        if ($pedido && $pedido->id != $pedidoId) {
            Cookie::queue('pedidoId', $pedido->id);
        }
    }

    public static function deletePedido(Pedido $pedido)
    {
        if ($pedido->status != StatusPedido::Aberto) {
            throw new OperacaoIlegalException("Não é permitido excluir um pedido que não esteja aberto");
        }

        $pedido->pedidoItens()->delete();
        $pedido->delete();
    }

    public static function adicionarItem(ItemListaPreco $item)
    {
        $pedido = self::getPedido();

        $pedidoItem = PedidoItem::create([
            'pedido_id' => $pedido->id,
            'item_lista_preco_id' => $item->id
        ]);

        $pedidoItem->preco_quilo = $item->preco_quilo;
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
            $pedidoItem->delete();

            RemovePedidoItem::dispatch();
        }
    }

    public static function redirecionarAdicionais(ItemListaPreco $item)
    {
        $tipo = $item->produto->tipoProduto;
        return ($tipo->tiposProdutosAdicionais()->count() > 0);
    }
}
