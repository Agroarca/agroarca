<?php

namespace App\Models\Pedidos;

use App\Models\Cadastros\CentroDistribuicao;
use App\Models\Estoque\Produto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItemListaPreco extends Model
{
    use HasFactory;
    protected $table = 'itens_lista_preco';
    protected $fillable = [
        'preco_quilo',
        'estoque_total',
        'estoque_vendido',
        'estoque_disponivel',
        'produto_id',
        'lista_preco_id',
        'centro_distribuicao_id',
        'base_frete',
        'data_inicial_entrega',
        'data_final_entrega',
        'minimo_dias_entrega'
    ];

    public function listaPreco(){
        return $this->belongsTo(ListaPreco::class);
    }

    public function produto(){
        return $this->belongsTo(Produto::class);
    }

    public function centroDistribuicao(){
        return $this->belongsTo(CentroDistribuicao::class);
    }

    public function calculaPreco($data = null){
        $data = new Carbon($data);
        return DB::select('SELECT juroItemListaPreco(?, ?) AS valor', [$this->id, $data])[0]->valor;
    }
}
