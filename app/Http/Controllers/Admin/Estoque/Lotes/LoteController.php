<?php

namespace App\Http\Controllers\Admin\Estoque\Lotes;

use App\Exceptions\OperacaoIlegalException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Estoque\LoteRequest;
use App\Models\Estoque\Lote;
use App\Models\Produtos\Produto;

class LoteController extends Controller
{
    public function inicio($produto_id = null)
    {
        $produto = Produto::find($produto_id);
        $lotes = [];
        if (!is_null($produto)) {
            $lotes = $produto->lotes()->paginate();
        }
        return view('admin.estoque.lotes.inicio', compact('produto'), compact('lotes'));
    }

    public function criar($produto_id)
    {
        $produto = Produto::find($produto_id);
        return view('admin.estoque.lotes.criar', compact('produto'));
    }

    public function salvar(LoteRequest $request, $produto_id)
    {
        $produto = Produto::find($produto_id);
        $lote = new Lote($request->all());
        $lote->produto_id = $produto->id;
        $lote->save();

        return redirect()->route('admin.estoque.lotes', $produto_id);
    }

    public function editar($produto_id, $lote_id)
    {
        $produto = Produto::find($produto_id);
        $lote = Lote::where('produto_id', $produto_id)->findOrFail($lote_id);
        return view('admin.estoque.lotes.editar', compact('lote'), compact('produto'));
    }

    public function atualizar(LoteRequest $request, $produto_id, $lote_id)
    {
        Lote::where('produto_id', $produto_id)->findOrFail($lote_id)->update($request->all());
        return redirect()->route('admin.estoque.lotes', $produto_id);
    }

    public function excluir($produto_id, $lote_id)
    {
        $lote = Lote::where('produto_id', $produto_id)->findOrFail($lote_id);

        if ($lote->movimentoLotes()->count() > 0) {
            throw new OperacaoIlegalException('Não é possível excluir um lote com movimentos cadastrados');
        }

        $lote->delete();
        return redirect()->route('admin.estoque.lotes', $produto_id);
    }
}
