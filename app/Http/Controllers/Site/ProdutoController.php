<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Estoque\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function produto($id){
        $produto = Produto::findOrFail($id);
        return view('site.produto.produto', compact('produto'));
    }
}
