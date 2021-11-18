<?php

namespace App\Models\Estoque;

use App\Models\Cadastros\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoFornecedor extends Model
{
    use HasFactory;
    protected $table = 'produtos_fornecedor';
    protected $fillable = [
        'estoque_total',
        'estoque_vendido',
        'estoque_disponivel',
        'produto_id',
        'fornecedor_id'
    ];

    public function produto(){
        return $this->belongsTo(Produto::class);
    }

    public function fornecedor(){
        return $this->belongsTo(Usuario::class);
    }
}
