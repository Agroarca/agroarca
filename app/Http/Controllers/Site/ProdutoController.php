<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\CEPRequest;
use App\Models\Produtos\Produto;
use App\Services\Site\EntregaService;
use App\Services\Site\PedidoService;
use App\Services\Site\ProdutoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    public function produto($id)
    {
        $produto = Produto::findOrFail($id);
        $precoProduto =  ProdutoService::getPrecosProduto($produto)[0];

        return view('site.produto.produto', compact('produto'), compact('precoProduto'));
    }

    public function atualizarCep(CEPRequest $request, $produtoId)
    {
        $cep = $request->input('cep') ?? $request->query('cep');
        $cep = preg_replace('/\D/', '', $cep);
        EntregaService::atualizarCepEnderecoPadrao($cep);

        return redirect()->route('site.produto', $produtoId);
    }

    public function adicionarItem(Request $request, $produtoId)
    {
        $produto = Produto::findOrFail($produtoId);
        $item = $produto->itensListaPreco()->first();

        $quantidade = $request->input('quantidade');
        $pedidoItem = PedidoService::adicionarItem($item, $quantidade);

        if (PedidoService::redirecionarAdicionais($item)) {
            return redirect()->route('site.carrinho', $pedidoItem->id);
        }

        return redirect()->route('site.carrinho');
    }
}
