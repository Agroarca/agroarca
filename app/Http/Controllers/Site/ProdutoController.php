<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\Pedido\PedidoItemController;
use App\Models\Estoque\Produto;
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
        $controller = new FreteController();
        $controller->atualizarCep($request);

        return redirect()->route('site.produto', $produtoId);
    }

    public function adicionarItem(Request $request, $produtoId)
    {
        $produto = Produto::findOrFail($produtoId);
        $item = $produto->itensListaPreco()->first();

        $controller = new PedidoItemController();
        $controller->adicionar($item);

        return redirect()->route('site.produto', $produtoId);
    }
}
