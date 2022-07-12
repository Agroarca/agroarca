<?php

namespace App\Http\Controllers\Admin\Pedidos;

use App\Enums\Pedidos\StatusPedido;
use App\Enums\Pedidos\TipoPedido;
use App\Exceptions\OperacaoIlegalException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pedidos\PedidoAtualizarRequest;
use App\Http\Requests\Pedidos\PedidoRequest;
use App\Models\Pedidos\Pedido;
use App\Models\Produtos\Produto;
use App\Services\Administracao\PedidoService;
use App\Services\Site\ListService;
use App\Services\Site\PedidoService as SitePedidoService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function inicio()
    {
        $pedidos = Pedido::where('tipo', '!=', TipoPedido::VendaEcommerce)
            ->orWhere('status', '!=', StatusPedido::Aberto)
            ->paginate(10);

        return view('admin.pedidos.pedidos.inicio', compact('pedidos'));
    }

    public function criar()
    {
        $tiposPedido = [
            TipoPedido::Compra => TipoPedido::getName(TipoPedido::Compra),
            TipoPedido::VendaInterna => TipoPedido::getName(TipoPedido::VendaInterna),
        ];

        return view('admin.pedidos.pedidos.criar', compact('tiposPedido'));
    }

    public function salvar(PedidoRequest $request)
    {
        $pedido = Pedido::create($request->all());
        return redirect()->route('admin.pedidos.pedidos.editar', $pedido->id);
    }

    public function editar($id)
    {
        $pedido = PedidoService::getDadosPedido(Pedido::findOrFail($id));
        return view('admin.pedidos.pedidos.editar', compact('pedido'));
    }

    public function atualizar(PedidoAtualizarRequest $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($request->has('usuario_id') && is_null($pedido->usuario_id)) {
            $pedido->usuario_id = $request->input('usuario_id');
        }

        if ($request->has('data_pagamento') && !is_null($request->input('data_pagamento'))) {
            $pedido->data_pagamento = Carbon::parse($request->input('data_pagamento'));
        } else {
            $pedido->data_pagamento = null;
        }

        if ($request->has('data_entrega') && !is_null($request->input('data_entrega'))) {
            $pedido->data_entrega = Carbon::parse($request->input('data_entrega'));
        } else {
            $pedido->data_entrega = null;
        }

        $pedido->update($request->only('usuario_id', 'forma_pagamento_id', 'endereco_id', 'observacao'));
        $pedido->save();

        SitePedidoService::calcularPedido($pedido);

        return response()->json(['pedido' => PedidoService::getDadosPedido($pedido)]);
    }

    public function produtos()
    {
        $pesquisa = '';

        if (array_key_exists('q', $_GET)) {
            $pesquisa = $_GET['q'];
        }

        $produtos = Produto::select('id', 'nome as text')
            ->where('nome', 'like', "%$pesquisa%")
            ->orWhere('codigo', 'like', "%$pesquisa%")
            ->orderBy('text')
            ->limit(30)
            ->get()
            ->toArray();

        return response()->json(['results' => $produtos]);
    }

    public function itensListaPreco()
    {
        $pesquisa = '';

        if (array_key_exists('q', $_GET)) {
            $pesquisa = $_GET['q'];
        }

        $produtos = ListService::queryListagemProdutos()->select('produtos.id', 'produtos.nome as text')
            ->where('nome', 'like', "%$pesquisa%")
            ->orWhere('codigo', 'like', "%$pesquisa%")
            ->orderBy('text')
            ->limit(30)
            ->get()
            ->toArray();

        return response()->json(['results' => $produtos]);
    }

    public function aprovarPedido($id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->status != StatusPedido::Aberto && $pedido->status != StatusPedido::Analise) {
            throw new OperacaoIlegalException("Não é possível aprovar um pedido nesse Status");
        }

        if ($pedido->status == StatusPedido::Aberto) {
            SitePedidoService::submeterPedido($pedido);
        }

        PedidoService::aprovarPedido($pedido);
        return response()->json(['pedido' => PedidoService::getDadosPedido($pedido)]);
    }

    public function submeterPedido($id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->status != StatusPedido::Aberto) {
            throw new OperacaoIlegalException("Não é possível submeter um pedido nesse Status");
        }

        SitePedidoService::submeterPedido($pedido);
        return response()->json(['pedido' => PedidoService::getDadosPedido($pedido)]);
    }

    public function excluir($id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->status != StatusPedido::Aberto) {
            throw new OperacaoIlegalException("Não é possível excluir um pedido nesse Status");
        }

        foreach ($pedido->pedidoItens as $pedidoItem) {
            $pedidoItem->pedidoItensAdicionais()->delete();
        }

        $pedido->pedidoItens()->delete();
        $pedido->delete();

        return redirect()->route("admin.pedidos.pedidos");
    }

    public function cancelar($id)
    {
        $pedido = Pedido::findOrFail($id);
        PedidoService::cancelarPedido($pedido);

        return redirect()->route("admin.pedidos.pedidos");
    }
}
