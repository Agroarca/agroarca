<?php

namespace App\Models\Frete;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distancia extends Model
{
    use HasFactory;
    protected $fillable = [
        'origem_place_id',
        'destino_place_id',
        'distancia'
    ];
}
