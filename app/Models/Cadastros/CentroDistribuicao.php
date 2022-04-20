<?php

namespace App\Models\Cadastros;

use App\Models\Pedidos\ItemListaPreco;
use App\Traits\Dominio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroDistribuicao extends Model
{
    use HasFactory, Dominio;

    protected $table = 'fornecedor_centros_distribuicao';
    protected $fillable = [
        'nome',
        'representante',
        'cnpj',
        'telefone',
        'inscricao_estadual',
        'usuario_id',
        'usuario_endereco_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function usuarioEndereco()
    {
        return $this->belongsTo(UsuarioEndereco::class);
    }

    public function itensListaPreco()
    {
        return $this->hasMany(ItemListaPreco::class);
    }
}
