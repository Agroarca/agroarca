<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Models\Estoque\Produto;
use App\Models\Estoque\Categoria;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Site\FrontendService;

class FrontendController extends Controller
{
    protected $perPage = 20;
    protected $frontServ;

    /**
     * Class constructor
     *
     * @param FrontendService $frontServ
     */
    public function __construct(FrontendService $frontServ)
    {
        $this->frontServ = $frontServ;
    }

    public function category($id = null)
    {
        $categoria = $this->frontServ->findCategoryById($id);
        $categorias = $this->frontServ->getRecursiveCategories($id);
        $produtos = $this->frontServ->queryBase()->whereIn('categoria_id', $categorias)->paginate($this->perPage);

        return view('site.listagem.listagem', compact('produtos'), compact('categoria'));
    }
}
