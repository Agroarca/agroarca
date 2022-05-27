<?php

namespace App\Http\Controllers\Admin\Produtos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produtos\ProdutoRequest;
use App\Models\Produtos\Produto;

class ProdutoController extends Controller
{
    public function inicio()
    {
        $produtos = Produto::orderBy('nome')->paginate(10);
        return view('admin.produtos.produtos.inicio', compact('produtos'));
    }

    public function criar()
    {
        return view('admin.produtos.produtos.criar');
    }

    public function salvar(ProdutoRequest $request)
    {
        $produto = Produto::create($request->all());
        return redirect()->route('admin.produtos.produtos.editar', $produto->id);
    }

    public function editar($id)
    {
        $pendencias = [];

        $produto = Produto::with('icmsEstado')->findOrFail($id);

        if (!($produto->icms_padrao > 0)) {
            $pendencias[] = "Preencha o ICMS Padrão do produto";
        }

        return view('admin.produtos.produtos.editar', compact('produto'), compact('pendencias'));
    }

    public function atualizar(ProdutoRequest $request, $id)
    {
        Produto::findOrFail($id)->update($request->all());
        return redirect()->route('admin.produtos.produtos.editar', $id);
    }

    public function excluir($id)
    {
        Produto::findOrFail($id)->delete();
        return redirect()->route('admin.produtos.produtos');
    }
}
