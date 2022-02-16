<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Pedidos\PedidoItem;
use App\Services\Site\PedidoService;

class CarrinhoController extends Controller
{
    public function inicio()
    {
        $pedido = PedidoService::getPedido();
        return view('site.carrinho.carrinho', compact('pedido'));
    }

    public function remover($itemId)
    {
        $pedidoItem = PedidoItem::findOrFail($itemId);
        PedidoService::removerItem($pedidoItem);
        return redirect()->route('site.carrinho');
    }
}
