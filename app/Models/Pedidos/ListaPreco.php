<?php

namespace App\Models\Pedidos;

use App\Models\Cadastros\Usuario;
use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaPreco extends Model
{
    use HasFactory, SoftDeletes, Dominio;
    protected $table = 'listas_preco';
    protected $fillable = [
        'nome',
        'data',
        'data_inicio',
        'data_fim',
        'ajuste_mensal',
        'fornecedor_id'
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function itens()
    {
        return $this->hasMany(ItemListaPreco::class);
    }
}
