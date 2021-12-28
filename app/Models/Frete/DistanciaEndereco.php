<?php

namespace App\Models\Frete;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistanciaEndereco extends Model
{
    use HasFactory;
    protected $table = 'distancia_enderecos';
    protected $fillable = [
        'endereco_origem_id',
        'endereco_destino_id',
        'distancia',
    ];
}
