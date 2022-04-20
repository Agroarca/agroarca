<?php

namespace App\Http\Controllers\Admin\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\Usuario;

class UsuarioController extends Controller
{
    public function inicio()
    {
        $usuarios = Usuario::orderBy('nome')->paginate(10);
        return view('admin.cadastros.usuarios.inicio', compact('usuarios'));
    }

    public function editar($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('admin.cadastros.usuarios.editar', compact('usuario'));
    }

    public function admin($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->admin = !$usuario->admin;
        $usuario->save();

        return redirect()->route('admin.cadastros.usuarios.editar', $id);
    }
}
