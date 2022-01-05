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
        TipoProduto::create($request->all());
        return redirect()->route('admin.estoque.tiposProduto');
    }

    public function editar($id) {
        $tipoProduto = TipoProduto::findOrFail($id);
        return view('admin.estoque.tiposProduto.editar', compact('tipoProduto'));
    }

    public function atualizar(TipoProdutoRequest $request, $id) {
        TipoProduto::findOrFail($id)->update($request->all());
        return redirect()->route('admin.estoque.tiposProduto');
    }

    public function excluir($id) {
        TipoProduto::findOrFail($id)->delete();
        return redirect()->route('admin.estoque.tiposProduto');
    }
}
