<?php

namespace App\Models\Cadastros;

use App\Jobs\EnderecoGeocodeJob;
use App\Models\Cadastros\Usuario;
use App\Traits\Dominio;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioEndereco extends Model
{
    use HasFactory, Dominio;

    protected $table = 'usuario_enderecos';
    protected $fillable = [
        'nome',
        'endereco',
        'bairro',
        'complemento',
        'numero',
        'cep',
        'cidade_id',
        'usuario_id',
        'google_place_id',
        'google_place_id_updated',
        'latitude',
        'longitude'
    ];

    protected static function boot()
    {
        parent::boot();
        static::saved(function ($endereco) {
            EnderecoGeocodeJob::dispatchAfterResponse($endereco);
        });
    }

    public function setGooglePlaceIdAttribute($value)
    {
        $this->attributes['google_place_id'] = $value;
        $this->attributes['google_place_id_updated'] = Carbon::now()->toDate();
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
