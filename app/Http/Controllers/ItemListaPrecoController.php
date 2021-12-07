<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pedidos\ItemListaPrecoRequest;
use App\Models\Pedidos\ItemListaPreco;
use Illuminate\Http\Request;

class ItemListaPrecoController extends Controller
{
    public function inicio(){
        $itensListaPreco = ItemListaPreco::orderBy('produto_id')->with(['produto', 'listaPreco'])->paginate(10);
        return view('admin.pedidos.listas_preco.itens.inicio', compact('itensListaPreco'));
    }

    public function criar(){
        return view('admin.pedidos.listas_preco.itens.criar');
    }

    public function salvar(ItemListaPrecoRequest $request){
        ItemListaPreco::create($request->all());
        //return redirect()->route('');
    }
}
