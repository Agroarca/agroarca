<?php

namespace App\Http\Controllers\Admin\Administracao;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\Usuario;
use App\Scopes\DominioScope;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    private function queryAdministradores()
    {
        return Usuario::withoutGlobalScope(DominioScope::class)->where('admin', true);
    }

    public function inicio()
    {
        $usuarios = $this->queryAdministradores()->orderBy('nome')->paginate(10);
        return view('admin.administracao.administradores.inicio', compact('usuarios'));
    }
}
