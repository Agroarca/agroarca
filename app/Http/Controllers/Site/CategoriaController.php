<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Estoque\Categoria;
use App\Models\Estoque\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends ListagemController
{
    public function categoria($id = null)
    {
        $categoria = Categoria::find($id);
        $categorias = $this->categorias($id);
        $produtos = $this->queryBase()->whereIn('categoria_id', $categorias)->paginate($this->perPage);
        return view('site.listagem.listagem', compact('produtos'), compact('categoria'));
    }

    private function categorias($id)
    {
        $categorias = DB::select('
            with recursive cats (id) as (
                select id
                from categorias
                where (
                    @id is null
                    and categoria_mae_id is null
                ) or (
                    @id is not null
                    and id = @id
                )
                union all
                select cat.id
                from categorias cat
                inner join cats on cat.categoria_mae_id = cats.id
            )
            select id from cats,
            (select @id := ?) inicializacao;', [$id]);

        return collect($categorias)->pluck('id');
    }
}
