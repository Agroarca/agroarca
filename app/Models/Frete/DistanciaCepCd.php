<?php

namespace App\Models\Frete;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistanciaCepCd extends Model
{
    use HasFactory;
    protected $table = 'distancia_cep_cd';
    protected $fillable = [
        'cep',
        'endereco_id',
        'distancia',
    ];
}
