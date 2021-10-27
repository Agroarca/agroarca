<?php

namespace App\Models\Cadastros;

use App\Models\Cadastros\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioEndereco extends Model
{
    use HasFactory;

    protected $table = 'usuario_enderecos';
    protected $fillable = [
        'nome',
        'endereco',
        'bairro',
        'complemento',
        'numero',
        'cep',
        'cidade_id',
        'usuario_id'
    ];

    public function cidade(){
        return $this->belongsTo(Cidade::class);
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }
}
