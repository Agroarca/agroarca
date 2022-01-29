<?php

namespace App\Models\Cadastros;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';
    protected $fillable = ['nome', 'uf'];
    public $timestamps = false;

    // Função Helper para construir selects com todos os estados
    public static function selectTodos(){
        return Estado::all()->mapWithKeys(function($estado, $id){
            return [ $estado->id => "$estado->uf - $estado->nome" ];
        });
    }

    public function cidades(){
        return $this->hasMany(Cidade::class);
    }
}
