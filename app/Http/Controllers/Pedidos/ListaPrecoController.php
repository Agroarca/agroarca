<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pedidos\ListaPrecoRequest;
use App\Models\Pedidos\ListaPreco;
use Illuminate\Support\Facades\Auth;

class ListaPrecoController extends Controller
{
    public function inicio(){
        $listasPreco = ListaPreco::orderBy('data_inicio', 'desc')->paginate(10);
        return view('admin.pedidos.listas_preco.inicio', compact('listasPreco'));
    }

    public function criar() {
        return view('admin.pedidos.listas_preco.criar');
    }

    public function salvar(ListaPrecoRequest $request) {
        $listaPreco = new ListaPreco($request->all());
        $listaPreco->fornecedor_id = Auth::user()->id;
        $listaPreco->save();
        return redirect()->route('admin.pedidos.listas_preco');
    }

    public function editar($id) {
        $listaPreco = ListaPreco::findOrFail($id);
        return view('admin.pedidos.listas_preco.editar', compact('listaPreco'));
    }

    public function atualizar(ListaPrecoRequest $request, $id) {
        $listaPreco = ListaPreco::findOrFail($id);
        $listaPreco->update($request->all());
        return redirect()->route('admin.pedidos.listas_preco');
    }

    public function excluir($id) {
        ListaPreco::findOrFail($id)->delete();
        return redirect()->route('admin.pedidos.listas_preco');
    }
}
