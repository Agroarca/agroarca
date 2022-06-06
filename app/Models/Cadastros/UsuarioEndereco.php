<?php

namespace App\Models\Cadastros;

use App\Jobs\EnderecoGeocodeJob;
use App\Models\Cadastros\Usuario;
use App\Services\Site\UsuarioService;
use App\Traits\Dominio;
use App\Traits\GooglePlaceId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioEndereco extends Model
{
    use HasFactory, Dominio, GooglePlaceId;

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

    public static function booted()
    {
        static::created(function (UsuarioEndereco $model) {
            UsuarioService::verificarEnderecoPadrao($model->usuario_id);
        });

        static::deleted(function (UsuarioEndereco $model) {
            UsuarioService::verificarEnderecoPadrao($model->usuario_id);
        });
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
