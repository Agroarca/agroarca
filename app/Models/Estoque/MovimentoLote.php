<?php

namespace App\Models\Estoque;

use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentoLote extends Model
{
    use HasFactory, Dominio;
    protected $table = 'movimentos_lote';
    protected $fillable = [
        'quantidade',
        'operacao',
        'lote_id',
    ];

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}
