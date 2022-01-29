<?php

namespace App\Http\Controllers\Admin\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function inicio(){
        $estados = Estado::orderBy('nome')->paginate(10);
        return view('admin.cadastros.estados.inicio', compact('estados'));
    }
}
