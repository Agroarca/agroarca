<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\Site\ListService;

class FrontendController extends Controller
{
    protected $listServ;

    /**
     * Class constructor
     *
     * @param ListService $listServ
     */
    public function __construct(ListService $listServ)
    {
        $this->listServ = $listServ;
    }

    public function category($id = null)
    {
        $categoria = $this->listServ->findCategoryById($id);
        $categorias = $this->listServ->getAllChildCategories($id);
        $produtos = $this->listServ::queryBase()->whereIn('categoria_id', $categorias)->paginate(config('agroarca.paginate.perPage'));

        return view('site.listagem.listagem', compact('produtos'), compact('categoria'));
    }
}
