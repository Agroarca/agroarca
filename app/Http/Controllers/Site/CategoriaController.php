<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Estoque\Categoria;
use App\Models\Estoque\Produto;
use Illuminate\Http\Request;

class CategoriaController extends ListagemController
{
    public function categoria($id = null){
        $categoria = Categoria::find($id);
        $categorias = $this->categorias($id);
        $produtos = $this->queryBase()->whereIn('categoria_id', $categorias)->paginate($this->perPage);
        return view('site.listagem.listagem', compact('produtos'), compact('categoria'));
    }

    private function categorias($id){
        $categoria = Categoria::find($id);
        $cats = [];

        if($categoria){
            $cats[] = $categoria->id;
        }

        $categorias = Categoria::where('categoria_mae_id', $id)->get();
        foreach($categorias as $categoria){
            $cats = array_merge($cats, $this->categorias($categoria->id));
        }

        return $cats;
    }
}
