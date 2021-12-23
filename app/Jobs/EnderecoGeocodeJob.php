<?php

namespace App\Jobs;

use App\Classes\Interfaces\GoogleGeocoding;
use App\Http\Controllers\Api\GoogleGeocodingController;
use App\Models\Cadastros\UsuarioEndereco;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EnderecoGeocodeJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;

    private $endereco;

    public function __construct(UsuarioEndereco $endereco)
    {
        $this->endereco = $endereco->withoutRelations();
    }

    public function uniqueId(){
        return $this->endereco->id;
    }


    public function handle()
    {
        $updated = Carbon::parse($this->endereco->google_pace_id_updated);
        $now = Carbon::now();
        if($this->endereco->google_pace_id_updated && $updated->diffInDays($now) < env('GOOGLE_PLACE_ID_REFRESH_DAYS')){
            return;
        }

        $controller = new GoogleGeocodingController();
        $endereco = new GoogleGeocoding($this->endereco->endereco, $this->endereco->numero, $this->endereco->cep);
        $retorno = $controller->consultarEndereco($endereco);

        if($retorno){
            $this->endereco->google_place_id = $retorno->placeId;
            $this->endereco->latitude = $retorno->latitude;
            $this->endereco->longitude = $retorno->longitude;
            $this->endereco->save();
        }
    }
}
