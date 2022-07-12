<?php

namespace App\Http\Controllers\Admin\Pedidos;

use App\Enums\Pedidos\TipoPedido;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pedidos\PedidoitemRequest;
use App\Models\Pedidos\Pedido;
use App\Models\Pedidos\PedidoItem;
use App\Services\Administracao\PedidoService;
use App\Services\Site\PedidoService as SitePedidoService;

class PedidoItemController extends Controller
{
    public function adicionar(PedidoitemRequest $request, $pedido_id)
    {
        $pedido = Pedido::findOrFail($pedido_id);

        $pedidoItem = new PedidoItem($request->except('produto_id'));
        $pedidoItem->pedido_id = $pedido->id;

        if ($pedido->tipo == TipoPedido::Compra) {
            $pedidoItem->produto_id = $request->input('produto_id');
        } else {
            $pedidoItem->item_lista_preco_id = $request->input('produto_id');
        }

        $pedidoItem->save();

        SitePedidoService::calcularPedido($pedido);

        return response()->json(['pedido' => PedidoService::getDadosPedido($pedido)]);
    }

    public function atualizar(PedidoitemRequest $request, $pedido_id, $id)
    {
        $item = PedidoItem::where('pedido_id', $pedido_id)->findOrFail($id);
        $item->update($request->only('quantidade', 'preco_quilo', 'frete', 'icms'));

        SitePedidoService::calcularPedido($item->pedido);
        return response()->json(['pedido' => PedidoService::getDadosPedido($item->pedido)]);
    }

    public function excluir($pedido_id, $id)
    {
        $item = PedidoItem::where('pedido_id', $pedido_id)->findOrFail($id);
        $item->delete();

        $pedido = Pedido::findOrFail($pedido_id);
        SitePedidoService::calcularPedido($pedido);
        return response()->json(['pedido' => PedidoService::getDadosPedido($pedido)]);
    }
}
