<?php

namespace App\Http\Controllers\Admin\Estoque;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estoque\ProdutoRequest;
use App\Models\Estoque\Produto;

class ProdutoController extends Controller
{
    public function inicio(){
        $produtos = Produto::orderBy('nome')->paginate(10);
        return view('admin.estoque.produtos.inicio', compact('produtos'));
    }

    public function criar() {
        return view('admin.estoque.produtos.criar');
    }

    public function salvar(ProdutoRequest $request) {
        Produto::create($request->all());
        return redirect()->route('admin.estoque.produtos');
    }

    public function editar($id) {
        $produto = Produto::findOrFail($id);
        return view('admin.estoque.produtos.editar', compact('produto'));
    }

    public function atualizar(ProdutoRequest $request, $id) {
        Produto::findOrFail($id)->update($request->all());
        return redirect()->route('admin.estoque.produtos');
    }

    public function excluir($id) {
        Produto::findOrFail($id)->delete();
        return redirect()->route('admin.estoque.produtos');
    }
}
