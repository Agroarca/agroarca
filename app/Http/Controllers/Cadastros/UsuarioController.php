<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\Estado;
use App\Models\Cadastros\Usuario;

class UsuarioController extends Controller
{
    public function inicio(){
        $usuarios = Usuario::orderBy('nome')->paginate(10);
        return view('admin.cadastros.usuarios.inicio', compact('usuarios'));
    }

    public function editar($id){
        $usuario = Usuario::findOrFail($id);
        return view('admin.cadastros.usuarios.editar', compact('usuario'));
    }
}
