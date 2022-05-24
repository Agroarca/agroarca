<?php

namespace App\Http\Controllers\Admin\Cadastros;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastros\CentroDistribuicaoRequest;
use App\Models\Cadastros\CentroDistribuicao;

class CentroDistribuicaoController extends Controller
{
    public function inicio()
    {
        $centrosDistribuicao = CentroDistribuicao::orderBy('nome')->paginate(10);
        return view('admin.cadastros.centrosDistribuicao.inicio', compact('centrosDistribuicao'));
    }

    public function criar()
    {
        return view('admin.cadastros.centrosDistribuicao.criar');
    }

    public function salvar(CentroDistribuicaoRequest $request)
    {
        CentroDistribuicao::create($request->all());
        return redirect()->route('admin.cadastros.centrosDistribuicao');
    }

    public function editar($id)
    {
        $centroDistribuicao = CentroDistribuicao::findOrFail($id);
        return view('admin.cadastros.centrosDistribuicao.editar', compact('centroDistribuicao'));
    }

    public function atualizar(CentroDistribuicaoRequest $request, $id)
    {
        CentroDistribuicao::findOrFail($id)->update($request->all());
        return redirect()->route('admin.cadastros.centrosDistribuicao');
    }

    public function excluir($id)
    {
        CentroDistribuicao::findOrFail($id)->delete();
        return redirect()->route('admin.cadastros.centrosDistribuicao');
    }
}
