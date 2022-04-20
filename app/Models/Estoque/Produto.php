<?php

namespace App\Models\Estoque;

use App\Models\Pedidos\ItemListaPreco;
use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory, Dominio;
    protected $table = 'produtos';
    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'descricao_longa',
        'marca_id',
        'tipo_produto_id',
        'categoria_id',
        'icms_padrao'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function tipoProduto()
    {
        return $this->belongsTo(TipoProduto::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function imagens()
    {
        return $this->hasMany(ProdutoImagem::class);
    }

    public function itensListaPreco()
    {
        return $this->hasMany(ItemListaPreco::class);
    }

    public function icmsEstado()
    {
        return $this->hasMany(ICMSProdutoEstado::class);
    }
}
