<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Produtos\Categoria;
use App\Services\Site\ListService;

class CategoriaController extends Controller
{
    public function categoria($id = null)
    {
        $categoria = Categoria::find($id);
        $produtos = ListService::queryListagemCategoria($id)->paginate(config('agroarca.paginate.perPage'));

        return view('site.listagem.listagem', compact('produtos'), compact('categoria'));
    }
}
