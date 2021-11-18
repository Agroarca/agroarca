<?php

namespace App\Http\Controllers\Estoque;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoFornecedorRequest;
use App\Models\Estoque\ProdutoFornecedor;
use Illuminate\Support\Facades\Auth;

class ProdutoFornecedorController extends Controller
{
    public function inicio(){
        $produtos = //ProdutoFornecedor::with('produto')->orderBy('produto.nome')->paginate(10);
        ProdutoFornecedor::orderBy('id')->with('produto')->paginate(10);
        return view('admin.estoque.produtoFornecedor.inicio', compact('produtos'));
    }

    public function criar(){
        return view('admin.estoque.produtoFornecedor.criar');
    }

    public function salvar(ProdutoFornecedorRequest $request){
        $produto = new ProdutoFornecedor($request->all());
        $produto->fornecedor_id = Auth::user()->id;
        $produto->save();

        return redirect()->route('admin.estoque.produtoFornecedor');
    }

    public function editar($id) {
        $produto = ProdutoFornecedor::findOrFail($id);
        return view('admin.estoque.produtoFornecedor.editar', compact('produto'));
    }

    public function atualizar(ProdutoFornecedorRequest $request, $id) {
        $produto = ProdutoFornecedor::findOrFail($id);
        $produto->estoque_disponivel = $request->input('estoque_disponivel');
        $produto->save();

        return redirect()->route('admin.estoque.produtoFornecedor');
    }

    public function excluir($id) {
        ProdutoFornecedor::findOrFail($id)->delete();
        return redirect()->route('admin.estoque.produtoFornecedor');
    }
}
