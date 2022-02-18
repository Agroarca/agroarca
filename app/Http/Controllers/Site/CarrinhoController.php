<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Pedidos\ItemListaPreco;
use App\Models\Pedidos\PedidoItem;
use App\Services\Site\ListService;
use App\Services\Site\PedidoService;
use Illuminate\Http\Request;

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

    public function editar($pedidoItemId)
    {
        $pedidoItem = PedidoItem::findOrFail($pedidoItemId);
        $produtos = [];

        if ($pedidoItem->quantidade > 0) {
            $produtos = ListService::queryItensAdicionaisPedido($pedidoItem)->get();
        }

        return view('site.adicionais.adicionais', compact('pedidoItem'), compact('produtos'));
    }

    public function salvar(Request $request, $pedidoItemId)
    {
        $pedidoItem = PedidoItem::findOrFail($pedidoItemId);
        $pedidoItem->update([
            'quantidade' => $request->input('quantidade')
        ]);

        if (!$request->has('adicional')) {
            return redirect()->route('site.carrinho.editar', $pedidoItemId)->withInput();
        }

        foreach ($request->input('adicional') as $adicional) {
            $itemAdicional = ItemListaPreco::findOrFail($adicional);
            PedidoService::adicionarItemAdicional($pedidoItem, $itemAdicional);
        }

        return redirect()->route('site.carrinho');
    }
}
