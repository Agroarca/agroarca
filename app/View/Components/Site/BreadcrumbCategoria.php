<?php

namespace App\View\Components\Site;

use App\Classes\BreadcrumbLink;
use App\Models\Produtos\Categoria;
use Illuminate\View\Component;

class BreadcrumbCategoria extends Breadcrumb
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Categoria $categoria)
    {
        $links = [];
        while ($categoria) {
            $link = new BreadcrumbLink(route('site.categoria', $categoria->id), $categoria->nome);
            array_push($links, $link);

            $categoria = $categoria->categoriaMae;
        }

        $link = new BreadcrumbLink(route('inicio'), 'Início');
        array_push($links, $link);

        parent::__construct(collect($links)->reverse());
    }
}
