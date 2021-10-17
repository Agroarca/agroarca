<?php

namespace App\Models\Cadastros;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $table = 'cidades';
    protected $fillable = [ 'nome', 'estado_id' ];

    public function estado(){
        return $this->belongsTo(Estado::class);
    }
}
