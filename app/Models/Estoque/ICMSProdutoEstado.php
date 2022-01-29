<?php

namespace App\Models\Estoque;

use App\Models\Cadastros\Estado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ICMSProdutoEstado extends Model
{
    use HasFactory;
    protected $table = 'icms_produto_estado';
    protected $fillable = [
        'icms',
        'estado_id',
        'produto_id',
    ];

    public function produto(){
        return $this->belongsTo(Produto::class);
    }

    public function estado(){
        return $this->belongsTo(Estado::class);
    }
}
