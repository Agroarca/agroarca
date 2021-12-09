<?php

namespace App\Models\Estoque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
    use HasFactory;
    protected $table = 'tipos_produto';
    protected $fillable = ['nome'];

    public function produtos(){
        return $this->hasMany(Produto::class);
    }
}
