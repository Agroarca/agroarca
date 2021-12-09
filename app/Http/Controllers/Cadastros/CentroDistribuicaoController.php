<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastros\CentroDistribuicaoRequest;
use App\Models\Cadastros\CentroDistribuicao;
use App\Models\Cadastros\Usuario;

class CentroDistribuicaoController extends Controller
{
    public function criar($usuarioId) {
        $usuario = Usuario::findOrFail($usuarioId);
        return view('admin.cadastros.usuarios.centros_distribuicao.criar', compact('usuario'));
    }

    public function salvar(CentroDistribuicaoRequest $request, $usuarioId) {
        $centroDistribuicao = new CentroDistribuicao($request->all());
        $centroDistribuicao->usuario_id = $usuarioId;
        $centroDistribuicao->save();

        return redirect()->route('admin.cadastros.usuarios.editar', $usuarioId);
    }

    public function editar($usuarioId, $id) {
        $centroDistribuicao = CentroDistribuicao::where('usuario_id', $usuarioId)->findOrFail($id);
        $usuario = $centroDistribuicao->usuario;
        return view('admin.cadastros.usuarios.centros_distribuicao.editar', compact('centroDistribuicao'), compact('usuario'));
    }

    public function atualizar(CentroDistribuicaoRequest $request, $usuarioId, $id) {
        CentroDistribuicao::findOrFail($id)->update($request->all());
        return redirect()->route('admin.cadastros.usuarios.editar', $usuarioId);
    }

    public function excluir($usuarioId, $id) {
        CentroDistribuicao::where('usuario_id', $usuarioId)->findOrFail($id)->delete();
        return redirect()->route('admin.cadastros.usuarios.editar', $usuarioId);
    }
}
