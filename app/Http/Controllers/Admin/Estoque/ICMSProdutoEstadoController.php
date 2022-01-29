<?php

namespace App\Http\Controllers\Admin\Estoque;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estoque\ICMSProdutoEstado\AdicionarRequest;
use App\Http\Requests\Estoque\ICMSProdutoEstado\AtualizarRequest;
use App\Models\Estoque\ICMSProdutoEstado;
use App\Models\Estoque\Produto;

class ICMSProdutoEstadoController extends Controller
{
    public function atualizar(AtualizarRequest $request, $produto_id){
        Produto::findOrFail($produto_id)->update($request->all());
        return redirect()->route('admin.estoque.produtos.editar', $produto_id);
    }

    public function adicionar(AdicionarRequest $request, $produto_id){
        ICMSProdutoEstado::create($request->all());
        return redirect()->route('admin.estoque.produtos.editar', $produto_id);
    }

    public function excluir($produto_id, $id){
        ICMSProdutoEstado::findOrFail($id)->delete();
        return redirect()->route('admin.estoque.produtos.editar', $produto_id);
    }
}
