<?php

namespace App\Models\Pedidos;

use App\Models\Estoque\Produto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemListaPreco extends Model
{
    use HasFactory;
    protected $table = 'listas_preco';
    protected $fillable = [
        'preco_quilo',
        'estoque_total',
        'estoque_vendido',
        'estoque_disponivel',
        'produto_id',
        'lista_preco_id'
    ];

    public function listaPreco(){
        return $this->belongsTo(ListaPreco::class);
    }

    public function produto(){
        return $this->belongsTo(Produto::class);
    }
}
