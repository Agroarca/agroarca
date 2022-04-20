<?php

namespace App\Models\Estoque;

use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoImagem extends Model
{
    use HasFactory, Dominio;
    protected $table = 'produto_imagens';
    protected $fillable = ['descricao', 'nome_arquivo', 'produto_id'];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
