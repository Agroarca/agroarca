<?php

namespace App\Http\Controllers\Admin\Administracao;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administracao\DominioRequest;
use App\Models\Administracao\Dominio;

class DominioController extends Controller
{
    public function inicio()
    {
        $dominios = Dominio::orderBy('nome')->paginate(10);
        return view('admin.administracao.dominios.inicio', compact('dominios'));
    }

    public function criar()
    {
        return view('admin.administracao.dominios.criar');
    }

    public function salvar(DominioRequest $request)
    {
        Dominio::create($request->all());
        return redirect()->route('admin.administracao.dominios');
    }

    public function editar($id)
    {
        $dominio = Dominio::findOrFail($id);
        return view('admin.administracao.dominios.editar', compact('dominio'));
    }

    public function atualizar(DominioRequest $request, $id)
    {
        Dominio::findOrFail($id)->update($request->all());
        return redirect()->route('admin.administracao.dominios');
    }

    public function excluir($id)
    {
        Dominio::findOrFail($id)->delete();
        return redirect()->route('admin.administracao.dominios');
    }
}
