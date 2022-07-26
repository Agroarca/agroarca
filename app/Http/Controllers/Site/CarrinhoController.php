<?php

namespace App\Http\Controllers\Site;

use App\Enums\Pedidos\ModalidadeFormaPagamento;
use App\Events\Site\CarrinhoAlteradoEvent;
use App\Exceptions\OperacaoIlegalException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastros\UsuarioEnderecoRequest;
use App\Models\Cadastros\Usuario;
use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Pedidos\FormaPagamento;
use App\Models\Pedidos\ItemListaPreco;
use App\Models\Pedidos\PedidoItem;
use App\Services\Site\CarrinhoService;
use App\Services\Site\ListService;
use App\Services\Site\PedidoService;
use App\Services\Site\UsuarioService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    public function inicio()
    {
        CarrinhoAlteradoEvent::dispatch();
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

        CarrinhoAlteradoEvent::dispatch();

        return response()->json(['carrinho' => CarrinhoService::getCarrinho()]);
    }

    public function continuar()
    {
        $usuario = Usuario::findOrFail(Auth::id());
        $checkoutDados = CarrinhoService::getDadosPedidoFinalizacao();
        return view('site.checkout.checkout', compact('usuario'), compact('checkoutDados'));
    }

    public function adicionarEndereco()
    {
        return view('site.checkout.adicionar_endereco');
    }

    public function salvarEndereco(UsuarioEnderecoRequest $request)
    {
        $endereco = new UsuarioEndereco($request->all());
        $endereco->usuario_id = Auth::id();
        $endereco->save();

        UsuarioService::verificarEnderecoPadrao();
        return redirect()->route('site.carrinho.continuar');
    }

    public function excluirEndereco($id)
    {
        $endereco = UsuarioEndereco::where('usuario_id', Auth::id())->findOrFail($id);
        $pedido = PedidoService::getPedido();

        if ($pedido->endereco_id == $endereco->id) {
            $pedido->endereco_id = null;
            $pedido->save();
        }

        $endereco->delete();

        UsuarioService::verificarEnderecoPadrao();
        return response()->json(['checkout' => CarrinhoService::getDadosPedidoFinalizacao()]);
    }

    public function selecionarEndereco($id)
    {
        $endereco = UsuarioEndereco::where('usuario_id', Auth::id())->findOrFail($id);
        $pedido = PedidoService::getPedido();
        $pedido->endereco_id = $endereco->id;
        $pedido->save();

        return response()->json(['checkout' => CarrinhoService::getDadosPedidoFinalizacao()]);
    }

    public function selecionarFormaPagamento($id)
    {
        $formaPagamento = FormaPagamento::findOrFail($id);

        $pedido = PedidoService::getPedido();
        $pedido->forma_pagamento_id = $formaPagamento->id;

        if ($formaPagamento->modalidade == ModalidadeFormaPagamento::AVista) {
            $formaPagamento->data_pagamento = null;
        }

        $pedido->save();

        return response()->json(['checkout' => CarrinhoService::getDadosPedidoFinalizacao()]);
    }

    public function alterarDataPagamento(Request $request)
    {
        $data = Carbon::parse($request->input('data'));
        $pedido = PedidoService::getPedido();
        $pedido->data_pagamento = $data;
        $pedido->save();

        return response()->json(['checkout' => CarrinhoService::getDadosPedidoFinalizacao()]);
    }

    public function alterarDataEntrega(Request $request)
    {
        $data = Carbon::parse($request->input('data'));
        $pedido = PedidoService::getPedido();
        $pedido->data_entrega = $data;
        $pedido->save();

        return response()->json(['checkout' => CarrinhoService::getDadosPedidoFinalizacao()]);
    }

    public function finalizar()
    {
        $pedido = PedidoService::getPedido();
        $validator = PedidoService::validatorPedido($pedido);
        if ($validator->fails()) {
            return response()->json(['erros' => $validator->errors(), 'checkout' => CarrinhoService::getDadosPedidoFinalizacao()]);
        }

        try {
            PedidoService::submeterPedido($pedido);
        } catch (OperacaoIlegalException $e) {
            return response()->json(['erros' => [$e->getMessage()], 'checkout' => CarrinhoService::getDadosPedidoFinalizacao()]);
        }

        return response()->json(['redirect' => route('site.carrinho.resumo')]);
    }

    public function resumo()
    {
    }
}
