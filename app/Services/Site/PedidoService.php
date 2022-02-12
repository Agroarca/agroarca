<?php

namespace App\Services\Site;

use App\Enums\Pedidos\StatusPedido;
use App\Events\Pedido\AddPedidoItem;
use App\Exceptions\OperacaoIlegalException;
use App\Models\Pedidos\ItemListaPreco;
use App\Models\Pedidos\Pedido;
use App\Models\Pedidos\PedidoItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PedidoService
{

    public function getPedido()
    {
        $pedido = $this->getPedidoCookie();
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

        $this->setPedidoCookie($pedido);
        return $pedido;
    }

    private function getPedidoCookie()
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

    private function setPedidoCookie(Pedido $pedido)
    {
        $pedidoId = Cookie::get('pedidoId');
        if ($pedido && $pedido->id != $pedidoId) {
            Cookie::queue('pedidoId', $pedido->id);
        }
    }

    public function deletePedido(Pedido $pedido)
    {
        if ($pedido->status != StatusPedido::Aberto) {
            throw new OperacaoIlegalException("Não é permitido excluir um pedido que não esteja aberto");
        }

        $pedido->pedidoItens()->delete();
        $pedido->delete();
    }

    public function adicionarItem(ItemListaPreco $item)
    {
        $pedido = $this->getPedido();

        $pedidoItem = PedidoItem::create([
            'pedido_id' => $pedido->id,
            'item_lista_preco_id' => $item->id
        ]);

        $pedidoItem->preco_quilo = $item->preco_quilo;
        $pedidoItem->save();

        AddPedidoItem::dispatch($pedidoItem);

        return $pedidoItem;
    }

    public function redirecionarAdicionais(ItemListaPreco $item)
    {
        $tipo = $item->produto->tipoProduto;
        return ($tipo->tiposProdutosAdicionais()->count() > 0);
    }
}
