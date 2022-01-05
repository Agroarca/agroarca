<?php

namespace App\Http\Controllers\Admin\Cadastros;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastros\CidadeRequest;
use App\Models\Cadastros\Cidade;

class CidadeController extends Controller
{
    public function inicio(){
        $cidades = Cidade::orderBy('nome')->paginate(10);
        return view('admin.cadastros.cidades.inicio', compact('cidades'));
    }

    public function criar() {
        return view('admin.cadastros.cidades.criar');
    }

    public function salvar(CidadeRequest $request) {
        Cidade::create($request->all());
        return redirect()->route('admin.cadastros.cidades');
    }

    public function editar($id) {
        $cidade = Cidade::findOrFail($id);
        return view('admin.cadastros.cidades.editar', compact('cidade'));
    }

    public function atualizar(CidadeRequest $request, $id) {
        Cidade::findOrFail($id)->update($request->all());
        return redirect()->route('admin.cadastros.cidades');
    }

    public function excluir($id) {
        Cidade::findOrFail($id)->delete();
        return redirect()->route('admin.cadastros.cidades');
    }
}
