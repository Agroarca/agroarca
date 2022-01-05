<?php

namespace App\Jobs;

use App\Classes\Interfaces\GoogleGeocoding;
use App\Http\Controllers\Api\GoogleGeocodingController;
use App\Http\Controllers\Frete\DistanciasController;
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
        $controller = new DistanciasController();
        $controller->verificarAtualizarPlaceId($this->endereco);
    }
}
