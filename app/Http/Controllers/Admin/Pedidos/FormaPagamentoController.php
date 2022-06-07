<?php

namespace App\Http\Controllers\Admin\Pedidos;

use App\Http\Controllers\Controller;
use App\Models\Pedidos\FormaPagamento;
use Illuminate\Http\Request;

class FormaPagamentoController extends Controller
{
    public function inicio()
    {
        $formasPagamento = FormaPagamento::orderBy('nome')->paginate(10);
        return view('admin.pedidos.formas_pagamento.inicio', compact('formasPagamento'));
    }

    public function criar()
    {
        return view('admin.pedidos.formas_pagamento.criar');
    }

    public function salvar(Request $request)
    {
        $formaPagamento = new FormaPagamento($request->all());
        $formaPagamento->save();
        return redirect()->route('admin.pedidos.formas_pagamento');
    }

    public function editar($id)
    {
        $formaPagamento = FormaPagamento::findOrFail($id);
        return view('admin.pedidos.formas_pagamento.editar', compact('formaPagamento'));
    }

    public function atualizar(Request $request, $id)
    {
        $formaPagamento = FormaPagamento::findOrFail($id);
        $formaPagamento->update($request->all());
        return redirect()->route('admin.pedidos.formas_pagamento');
    }

    public function excluir($id)
    {
        FormaPagamento::findOrFail($id)->delete();
        return redirect()->route('admin.pedidos.formas_pagamento');
    }
}
