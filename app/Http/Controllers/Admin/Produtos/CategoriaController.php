<?php

namespace App\Http\Controllers\Admin\Produtos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produtos\CategoriaRequest;
use App\Models\Produtos\Categoria;

class CategoriaController extends Controller
{
    public function inicio()
    {
        $categorias = Categoria::orderBy('nome')->paginate(10);
        return view('admin.produtos.categorias.inicio', compact('categorias'));
    }

    public function criar()
    {
        return view('admin.produtos.categorias.criar');
    }

    public function salvar(CategoriaRequest $request)
    {
        Categoria::create($request->all());
        return redirect()->route('admin.produtos.categorias');
    }

    public function editar($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.produtos.categorias.editar', compact('categoria'));
    }

    public function atualizar(CategoriaRequest $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());
        return redirect()->route('admin.produtos.categorias');
    }

    public function excluir($id)
    {
        Categoria::findOrFail($id)->delete();
        return redirect()->route('admin.produtos.categorias');
    }
}
