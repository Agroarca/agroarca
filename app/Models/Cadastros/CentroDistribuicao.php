<?php

namespace App\Models\Cadastros;

use App\Jobs\EnderecoGeocodeJob;
use App\Models\Pedidos\ItemListaPreco;
use App\Traits\Dominio;
use App\Traits\GooglePlaceId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroDistribuicao extends Model
{
    use HasFactory, Dominio, GooglePlaceId;

    protected $table = 'centros_distribuicao';
    protected $fillable = [
        'nome',
        'representante',
        'cnpj',
        'telefone',
        'inscricao_estadual',
        'endereco',
        'bairro',
        'complemento',
        'numero',
        'cep',
        'cidade_id'
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function itensListaPreco()
    {
        return $this->hasMany(ItemListaPreco::class);
    }
}
