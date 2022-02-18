<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Estoque\Produto;
use App\Models\Pedidos\ItemListaPreco;
use App\Models\Pedidos\PedidoItem;
use App\Services\Site\EntregaService;
use App\Services\Site\ListService;
use App\Services\Site\PedidoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    public function produto($id)
    {
        $produto = Produto::findOrFail($id);

        $controller = new ProdutoPrecoController();
        $precoProduto =  $controller->getPrecoProduto($produto);

        return view('site.produto.produto', compact('produto'), compact('precoProduto'));
    }

    public function atualizarCep(Request $request, $produtoId)
    {
        $cep = $request->input('cep') ?? $request->query('cep');
        EntregaService::atualizarCepCookie($cep);

        return redirect()->route('site.produto', $produtoId);
    }

    public function adicionarItem(Request $request, $produtoId)
    {
        $produto = Produto::findOrFail($produtoId);
        $item = $produto->itensListaPreco()->first();

        $pedidoItem = PedidoService::adicionarItem($item);

        if (PedidoService::redirecionarAdicionais($item)) {
            return redirect()->route('site.carrinho.editar', $pedidoItem->id); //TODO
        }

        return redirect()->route('site.produto', $produtoId);
    }
}
