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
    protected $pedidoService;
    protected $entregaService;

    public function __construct()
    {
        $this->pedidoService = new PedidoService();
        $this->entregaService = new EntregaService();
    }

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
        $this->entregaService->atualizarCep($cep);

        return redirect()->route('site.produto', $produtoId);
    }

    public function adicionarItem(Request $request, $produtoId)
    {
        $produto = Produto::findOrFail($produtoId);
        $item = $produto->itensListaPreco()->first();

        $pedidoItem = $this->pedidoService->adicionarItem($item);

        if ($this->pedidoService->redirecionarAdicionais($item)) {
            return redirect()->route('site.adicionaisPedido', $pedidoItem->id); //TODO
        }

        return redirect()->route('site.produto', $produtoId);
    }

    public function adicionais($pedidoItemId)
    {
        $item = PedidoItem::findOrFail($pedidoItemId);

        $produtos = ListService::queryItensAdicionaisPedido($item)->get();

        return view('site.adicionais.adicionais', compact('produtos'));
    }
}
