<?php

namespace App\Http\Controllers\Estoque;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estoque\MarcaRequest;
use App\Models\Estoque\Marca;

class MarcaController extends Controller
{
    public function inicio(){
        $marcas = Marca::orderBy('nome')->paginate(10);
        return view('admin.estoque.marcas.inicio', compact('marcas'));
    }

    public function criar() {
        return view('admin.estoque.marcas.criar');
    }

    public function salvar(MarcaRequest $request) {
        Marca::create($request->all());
        return redirect()->route('admin.estoque.marcas');
    }

    public function editar($id) {
        $marca = Marca::findOrFail($id);
        return view('admin.estoque.marcas.editar', compact('marca'));
    }

    public function atualizar(MarcaRequest $request, $id) {
        Marca::findOrFail($id)->update($request->all());
        return redirect()->route('admin.estoque.marcas');
    }

    public function excluir($id) {
        Marca::findOrFail($id)->delete();
        return redirect()->route('admin.estoque.marcas');
    }
}
