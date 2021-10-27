<?php

namespace App\Models\Estoque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $fillable = ['nome', 'categoria_mae_id'];

    public function categoriaMae(){
        return $this->belongsTo(Categoria::class);
    }

    public function categorias(){
        return $this->hasMany(Categoria::class, 'categoria_mae_id');
    }
}
