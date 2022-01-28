<?php

namespace App\Http\Controllers\Site\Pedido;

use App\Events\Pedido\AddPedidoItem;
use App\Http\Controllers\Controller;
use App\Models\Pedidos\ItemListaPreco;
use App\Models\Pedidos\PedidoItem;

class PedidoItemController extends Controller
{
    public function adicionar(ItemListaPreco $item)
    {
        $pedidoController = new PedidoController();
        $pedido = $pedidoController->getPedido();

        $pedidoItem = PedidoItem::firstOrCreate([
            'pedido_id' => $pedido->id,
            'item_lista_preco_id' => $item->id
        ]);

        $pedidoItem->preco_quilo = $item->preco_quilo;
        $pedidoItem->save();

        AddPedidoItem::dispatch($pedidoItem);
    }
}
