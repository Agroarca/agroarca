<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Estoque\Categoria;
use App\Services\Site\ListService;

class CategoriaController extends Controller
{
    public function categoria($id = null)
    {
        $categoria = Categoria::find($id);
        $categorias = ListService::getAllChildCategories($id);
        $sql = ListService::queryListarProdutos()->toSql();
        $produtos = ListService::queryListarProdutos()->whereIn('categoria_id', $categorias)->paginate(config('agroarca.paginate.perPage'));

        return view('site.listagem.listagem', compact('produtos'), compact('categoria'));
    }
}
