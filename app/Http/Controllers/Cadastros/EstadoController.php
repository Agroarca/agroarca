<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function inicio(){
        $estados = Estado::orderBy('nome')->paginate(10);
        return view('admin.cadastros.estado.inicio', compact('estados'));
    }

    public function editar($id){
        $estado = Estado::findOrFail($id);
        return view('admin.cadastros.estado.editar', compact('estado'));
    }

    public function atualizar(Request $request, $id){
        $estado = Estado::findOrFail($id);
        $estado->icms = $request->input('icms');
        $estado->save();

        return redirect()->route('admin.cadastros.estado');
    }
}
