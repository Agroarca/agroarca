<?php

namespace App\Http\Controllers\Admin\Cadastros;

use App\Enums\Cadastros\Usuarios\TipoUsuarioEnum;
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

        if ($usuario->tipo == TipoUsuarioEnum::Admin) {
            $usuario->tipo = TipoUsuarioEnum::Usuario;
        } else {
            $usuario->tipo = TipoUsuarioEnum::Admin;
        }

        $usuario->save();

        return redirect()->route('admin.cadastros.usuarios.editar', $id);
    }

    public function pesquisar()
    {
        $pesquisa = '';

        if (array_key_exists('q', $_GET)) {
            $pesquisa = $_GET['q'];
        }

        $usuarios = Usuario::select('id', 'nome as text')
            ->where('nome', 'like', "%$pesquisa%")
            ->orWhere('email', 'like', "%$pesquisa%")
            ->orWhere('cpf', 'like', "%$pesquisa%")
            ->orWhere('cnpj', 'like', "%$pesquisa%")
            ->orderBy('nome')
            ->limit(30)
            ->get()
            ->toArray();

        return response()->json(['results' => $usuarios]);
    }
}
