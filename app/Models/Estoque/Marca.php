<?php

namespace App\Models\Estoque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $table = 'marcas';
    protected $fillable = ['nome'];

    public function produtos(){
        return $this->hasMany(Produto::class);
    }
}