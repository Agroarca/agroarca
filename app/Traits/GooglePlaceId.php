<?php

namespace App\Traits;

use App\Jobs\EnderecoGeocodeJob;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use InvalidArgumentException;

trait GooglePlaceId
{
    public static function bootGooglePlaceId()
    {
        static::saved(function ($endereco) {
            if ($endereco->isDirty(['endereco', 'numero', 'cep'])) {
                EnderecoGeocodeJob::dispatchAfterResponse($endereco);
            }
        });
    }

    public function setGooglePlaceIdAttribute($value)
    {
        $this->attributes['google_place_id'] = $value;
        $this->attributes['google_place_id_updated'] = Carbon::now()->toDate();
    }

    public function getConsulta()
    {
        if (is_null($this->cep)) {
            throw new InvalidArgumentException("Endereço não tem CEP válido, não é possível consultar");
        }

        if (is_null($this->endereco) || is_null($this->numero)) {
            return "{$this->cep} Brasil";
        }

        return urlencode("{$this->endereco} {$this->numero}") . ";components=postalcode:{$this->cep}";
    }

    /********** DATABASE */
    public static function criarCampos(Blueprint $table)
    {
        $table->text('google_place_id')->nullable();
        $table->date('google_place_id_updated')->nullable();
        $table->double('latitude')->nullable();
        $table->double('longitude')->nullable();
    }

    public static function removerCampos(Blueprint $table)
    {
        $table->dropColumn('google_place_id');
        $table->dropColumn('google_place_id_updated');
        $table->dropColumn('latitude');
        $table->dropColumn('longitude');
    }
}
