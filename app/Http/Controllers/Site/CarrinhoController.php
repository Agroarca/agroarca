<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Pedidos\ItemListaPreco;
use App\Models\Pedidos\PedidoItem;
use App\Services\Site\CarrinhoService;
use App\Services\Site\ListService;
use App\Services\Site\PedidoService;
use App\View\Components\Site\Carrinho\CarrinhoItem;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    public function inicio()
    {
        $carrinho = CarrinhoService::getCarrinho();
        return view('site.carrinho.carrinho', compact('carrinho'));
    }

    public function remover($itemId)
    {
        $pedidoItem = PedidoItem::findOrFail($itemId);
        PedidoService::removerItem($pedidoItem);
        return response()->json(['carrinho' => CarrinhoService::getCarrinho()]);
    }

    public function editar($pedidoItemId)
    {
        $pedidoItem = PedidoItem::findOrFail($pedidoItemId);
        $produtos = [];

        if ($pedidoItem->quantidade > 0) {
            $produtos = ListService::queryItensAdicionaisPedido($pedidoItem)->get();
        }

        return view('site.carrinho.editar.editar', compact('pedidoItem'), compact('produtos'));
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

        PedidoService::removerAdicionaisExceto($pedidoItem, $request->input('adicional'));

        return redirect()->route('site.carrinho');
    }

    public function alterar_quantidade(Request $request, $itemId)
    {
        if (!$request->input('quantidade') > 0) {
            return response()->json(['erro' => 'Quantidade Inválida']);
        }

        $item = PedidoItem::findOrFail($itemId);
        $item->quantidade = $request->input('quantidade');
        $item->save();

        return response()->json(['carrinho' => CarrinhoService::getCarrinho()]);
    }
}
