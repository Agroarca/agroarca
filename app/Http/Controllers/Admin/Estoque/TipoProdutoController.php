<?php

namespace App\Http\Controllers\Admin\Estoque;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estoque\TipoProdutoRequest;
use App\Models\Estoque\TipoProduto;
use Illuminate\Http\Request;

class TipoProdutoController extends Controller
{
    public function inicio(){
        $tiposProduto = TipoProduto::orderBy('nome')->paginate(10);
        return view('admin.estoque.tiposProduto.inicio', compact('tiposProduto'));
    }

    public function criar() {
        return view('admin.estoque.tiposProduto.criar');
    }

    public function salvar(TipoProdutoRequest $request) {
        $tipoProduto = TipoProduto::create($request->all());
        return redirect()->route('admin.estoque.tiposProduto.editar', $tipoProduto->id);
    }

    public function editar($id) {
        $tipoProduto = TipoProduto::findOrFail($id);

        $tiposProdutosAdicionais = TipoProduto::where('id', '!=', $id)
                                            ->whereNotIn('id', $tipoProduto->tiposProdutosAdicionais()->select('id'))->get();

        return view('admin.estoque.tiposProduto.editar', compact('tipoProduto'), compact('tiposProdutosAdicionais'));
    }

    public function atualizar(TipoProdutoRequest $request, $id) {
        TipoProduto::findOrFail($id)->update($request->all());
        return redirect()->route('admin.estoque.tiposProduto.editar', $id);
    }

    public function excluir($id) {
        TipoProduto::findOrFail($id)->delete();
        return redirect()->route('admin.estoque.tiposProduto');
    }

    public function adicional(Request $request, $id){
        $tipoProduto = TipoProduto::findOrFail($id);
        $adicional = TipoProduto::findOrFail($request->input('tipo_produto_id'));

        $tipoProduto->tiposProdutosAdicionais()->attach($adicional);
        return redirect()->route('admin.estoque.tiposProduto.editar', $id);
    }
    public function excluirAdicional($id, $adicional){
        $tipoProduto = TipoProduto::findOrFail($id);
        $adicional = TipoProduto::findOrFail($adicional);

        $tipoProduto->tiposProdutosAdicionais()->detach($adicional);
        return redirect()->route('admin.estoque.tiposProduto.editar', $id);
    }
}
