<?php

namespace App\Http\Controllers\Admin\Pedidos;

use App\Http\Requests\Pedidos\ItemListaPrecoRequest;
use App\Models\Pedidos\ItemListaPreco;
use App\Http\Controllers\Controller;
use App\Models\Pedidos\ListaPreco;

class ItemListaPrecoController extends Controller
{
    public function inicio($lista_preco_id)
    {
        $listaPreco = ListaPreco::findOrFail($lista_preco_id);
        $itensListaPreco = ItemListaPreco::where('lista_preco_id', $lista_preco_id)->orderBy('produto_id')->with(['produto', 'listaPreco'])->paginate(10);
        return view('admin.pedidos.listas_preco.itens.inicio', compact('listaPreco'), compact('itensListaPreco'));
    }

    public function criar($lista_preco_id)
    {
        $listaPreco = ListaPreco::findOrFail($lista_preco_id);
        return view('admin.pedidos.listas_preco.itens.criar', compact('listaPreco'));
    }

    public function salvar(ItemListaPrecoRequest $request, $lista_preco_id)
    {
        ItemListaPreco::create($request->all());
        return redirect()->route('admin.pedidos.listas_preco.itens', $lista_preco_id);
    }

    public function editar($lista_preco_id, $id)
    {
        $listaPreco = ListaPreco::findOrFail($lista_preco_id);
        $itemListaPreco = ItemListaPreco::where('lista_preco_id', $lista_preco_id)->findOrFail($id);
        return view('admin.pedidos.listas_preco.itens.editar', compact('itemListaPreco'), compact('listaPreco'));
    }

    public function atualizar(ItemListaPrecoRequest $request, $lista_preco_id, $id)
    {
        $itemListaPreco = ItemListaPreco::where('lista_preco_id', $lista_preco_id)->findOrFail($id);
        $itemListaPreco->update($request->only(
            'preco_quilo',
            'estoque_disponivel',
            'base_frete'
        ));

        return redirect()->route('admin.pedidos.listas_preco.itens', $lista_preco_id);
    }

    public function excluir($lista_preco_id, $id)
    {
        ItemListaPreco::where('lista_preco_id', $lista_preco_id)->findOrFail($id)->delete();
        return redirect()->route('admin.pedidos.listas_preco.itens', $lista_preco_id);
    }
}
