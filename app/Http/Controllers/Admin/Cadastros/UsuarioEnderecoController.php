<?php

namespace App\Http\Controllers\Admin\Cadastros;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastros\UsuarioEnderecoRequest;
use App\Models\Cadastros\UsuarioEndereco;

class UsuarioEnderecoController extends Controller
{
    public function criar($userId){
        return view('admin.cadastros.usuarios.enderecos.criar', compact('userId'));
    }

    public function salvar(UsuarioEnderecoRequest $request, $userId){
        $endereco = new UsuarioEndereco();
        $endereco->usuario_id = $userId;
        $endereco->fill($request->all());
        $endereco->save();

        return redirect()->route('admin.cadastros.usuarios.editar', $userId);
    }

    public function editar($userId, $id){
        $endereco = UsuarioEndereco::where('usuario_id', $userId)->findOrFail($id);
        $usuario = $endereco->usuario;
        return view('admin.cadastros.usuarios.enderecos.editar', compact('endereco'), compact('usuario'));
    }

    public function atualizar(UsuarioEnderecoRequest $request, $userId, $id){
        UsuarioEndereco::where('usuario_id', $userId)->findOrFail($id)->update($request->all());
        return redirect()->route('admin.cadastros.usuarios.editar', $userId);
    }

    public function excluir($userId, $id){
        UsuarioEndereco::where('usuario_id', $userId)->findOrFail($id)->delete();
        return redirect()->route('admin.cadastros.usuarios.editar', $userId);
    }
}
