<?php

namespace App\Http\Controllers\Admin\Produtos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produtos\MarcaRequest;
use App\Models\Produtos\Marca;

class MarcaController extends Controller
{
    public function inicio()
    {
        $marcas = Marca::orderBy('nome')->paginate(10);
        return view('admin.produtos.marcas.inicio', compact('marcas'));
    }

    public function criar()
    {
        return view('admin.produtos.marcas.criar');
    }

    public function salvar(MarcaRequest $request)
    {
        Marca::create($request->all());
        return redirect()->route('admin.produtos.marcas');
    }

    public function editar($id)
    {
        $marca = Marca::findOrFail($id);
        return view('admin.produtos.marcas.editar', compact('marca'));
    }

    public function atualizar(MarcaRequest $request, $id)
    {
        Marca::findOrFail($id)->update($request->all());
        return redirect()->route('admin.produtos.marcas');
    }

    public function excluir($id)
    {
        Marca::findOrFail($id)->delete();
        return redirect()->route('admin.produtos.marcas');
    }
}
