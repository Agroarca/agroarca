<?php

namespace App\Http\Controllers\Admin\Pedidos;

use App\Enums\Estoque\OperacaoMovimentoLote;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pedidos\PedidoItemLoteMovimentoRequest;
use App\Models\Estoque\Lote;
use App\Models\Pedidos\PedidoItem;
use App\Services\Administracao\LoteService;
use App\Services\Administracao\PedidoService;
use Illuminate\Http\Request;

class PedidoItemLoteController extends Controller
{
    public function inicio($pedidoItemId)
    {
        $pedidoItem = PedidoItem::findOrFail($pedidoItemId);
        $lotes = LoteService::getLotesPedidoitem($pedidoItem);
        $quantidadeRestante = LoteService::getQuantidadeRestantePedidoItem($pedidoItem);

        return view('admin.pedidos.lotes.inicio', compact('pedidoItem'), compact('lotes'));
    }

    public function criarLote($pedidoItemId)
    {
        PedidoItem::findOrFail($pedidoItemId);

        return view('admin.pedidos.lotes.criar', compact('pedidoItemId'));
    }

    public function salvarLote(Request $request, $pedidoItemId)
    {
        $pedidoItem = PedidoItem::findOrFail($pedidoItemId);

        $lote = new Lote($request->all());
        $lote->produto_id = $pedidoItem->produto_id ?? $pedidoItem->itemListaPreco->produto_id;
        $lote->save();

        return redirect()->route('admin.pedidos.pedidos.itens.lotes', $pedidoItemId);
    }

    public function salvarMovimento(PedidoItemLoteMovimentoRequest $request, $pedidoItemId)
    {
        $pedidoItem = PedidoItem::findOrFail($pedidoItemId);

        if ($request->input('operacao') == OperacaoMovimentoLote::Soma) {
            LoteService::adicionarMovimento($pedidoItem, $request->input('lote_id'), $request->input('quantidade'));
        } else {
            LoteService::diminuirMovimento($pedidoItem, $request->input('lote_id'), $request->input('quantidade'));
        }

        $lotes = LoteService::getLotesPedidoitem($pedidoItem);
        return response()->json($lotes);
    }
}
