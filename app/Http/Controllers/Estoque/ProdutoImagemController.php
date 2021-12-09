<?php

namespace App\Http\Controllers\Estoque;

use App\Http\Controllers\Controller;
use App\Models\Estoque\Produto;
use App\Models\Estoque\ProdutoImagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoImagemController extends Controller
{
    public function upload(Request $request, $produtoId){
        $produto = Produto::findOrFail($produtoId);
        $imagem = new ProdutoImagem();
        $imagem->descricao = $request->input('descricao');
        $imagem->produto_id = $produtoId;

        if($request->hasFile('imagem')){
            $file = $request->file('imagem');
            $file->store("public/produtos/");

            $imagem->nome_arquivo = $file->hashName();
            $imagem->save();
        }

        return redirect()->route('admin.estoque.produtos.editar', $produtoId);
    }

    public function delete($produtoId, $imagemId){
        $imagem = ProdutoImagem::where('produto_id', $produtoId)->findOrFail($imagemId);
        Storage::delete("public/produtos/$imagem->nome_arquivo");
        $imagem->delete();

        return redirect()->route('admin.estoque.produtos.editar', $produtoId);
    }
}
