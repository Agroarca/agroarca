<?php

namespace App\Models\Cadastros;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cidade extends Model
{
    use HasFactory;

    protected $table = 'cidades';
    protected $fillable = ['nome', 'estado_id'];

    // Função Helper para construir selects com todas as cidades
    public static function selectTodos()
    {
        return DB::table('cidades')
            ->join('estados', 'cidades.estado_id', 'estados.id')
            ->select('cidades.id')
            ->selectRaw("concat(cidades.nome, ' - ', estados.uf) as cidade")
            ->orderBy('cidades.nome')
            ->get()
            ->pluck('cidade', 'id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
