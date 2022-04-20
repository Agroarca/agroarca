<?php

namespace App\Models\Estoque;

use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
    use HasFactory, Dominio;
    protected $table = 'tipos_produto';
    protected $fillable = ['nome', 'listavel'];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function tiposProdutosAdicionais()
    {
        return $this->belongsToMany(TipoProduto::class, 'tipos_produto_adicionais', 'tipo_produto_id', 'tipo_produto_adicional_id');
    }
}
