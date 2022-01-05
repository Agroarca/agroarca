<?php

namespace App\Http\Controllers\Frete;

use App\Classes\Interfaces\GoogleGeocoding;
use App\Http\Controllers\Api\GoogleDistanceMatrixController;
use App\Http\Controllers\Api\GoogleGeocodingController;
use App\Http\Controllers\Controller;
use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Frete\Cep;
use App\Models\Frete\DistanciaCepCd;
use App\Models\Frete\DistanciaEndereco;
use Carbon\Carbon;
use Exception;
use InvalidArgumentException;

class DistanciasController extends Controller
{
    private $placeIdRefresh;

    public function __construct(){
        $this->placeIdRefresh = env('GOOGLE_PLACE_ID_REFRESH_DAYS');
    }

    /*
    * Calcula a distância em metros entre a $origem e o $destino
    */
    public function calcularDistancia($origem, $destino){
        $this->verificarAtualizarPlaceId($origem);
        $this->verificarAtualizarPlaceId($destino);

        if(!$origem->google_place_id){
            throw new InvalidArgumentException("Endereço de origem não tem Place Id");
        }

        if(!$destino->google_place_id){
            throw new InvalidArgumentException("Endereço de destino não tem Place Id");
        }

        $distance = $this->consultarDistancia($origem, $destino);

        if(!is_numeric($distance)){
            throw new Exception("Não foi possível consultar as distâncias na Api do Google");
        }

        return $distance;
    }

    public function criarCep($nrCep){
        $cep = Cep::firstOrCreate(['cep' => $nrCep]);
        $this->verificarAtualizarPlaceId($cep);
        return $cep;
    }

    public function verificarAtualizarPlaceId($model){
        if($model->google_place_id){
            $updated = $model->google_place_id_updated;
            if(Carbon::now()->diffInDays($updated, true) < $this->placeIdRefresh){
                return;
            }
        }

        $controller = new GoogleGeocodingController();
        if($model instanceof Cep){
            $retorno = $controller->consultarCEP($model->cep);
        }else if($model instanceof UsuarioEndereco){
            $endereco = new GoogleGeocoding($model->endereco, $model->numero, $model->cep);
            $retorno = $controller->consultarEndereco($endereco);
        }

        if($retorno){
            $model->google_place_id = $retorno->placeId;
            $model->latitude = $retorno->latitude;
            $model->longitude = $retorno->longitude;
            $model->save();
        }
    }

    private function consultarDistancia($origem, $destino){
        if($origem instanceof Cep && $destino instanceof UsuarioEndereco){
            return $this->consultarDistanciaCepEndereco($origem, $destino);
        }

        if($origem instanceof UsuarioEndereco && $destino instanceof UsuarioEndereco){
            return $this->consultarDistanciaEnderecos($origem, $destino);
        }
    }

    private function consultarDistanciaEnderecos(UsuarioEndereco $origem, UsuarioEndereco $destino){
        $endereco = DistanciaEndereco::where('endereco_origem_id', $origem->id)
                                        ->where('endereco_destino_id', $destino->id)
                                        ->where('updated_at', '>', Carbon::now()->subDays($this->placeIdRefresh))
                                        ->first();

        if($endereco){
            return $endereco->distancia;
        }

        $distanceController = new GoogleDistanceMatrixController();
        $distance = $distanceController->consultar([$origem->google_place_id], [$destino->google_place_id]);

        if(!$distance){
            return null;
        }

        DistanciaEndereco::updateOrCreate(
            [
                'endereco_origem_id' => $origem->id,
                'endereco_destino_id' => $destino->id
            ],
            ['distancia' => $distance[0][0]]
        );

        return $distance[0][0];
    }

    private function consultarDistanciaCepEndereco(Cep $cep, UsuarioEndereco $endereco){
        $distancia = DistanciaCepCd::where('cep', $cep->cep)
                                        ->where('endereco_id', $endereco->id)
                                        ->where('updated_at', '>', Carbon::now()->subDays($this->placeIdRefresh))
                                        ->first();

        if($distancia){
            return $distancia->distancia;
        }

        $distanceController = new GoogleDistanceMatrixController();
        $distance = $distanceController->consultar([$cep->google_place_id], [$endereco->google_place_id]);

        if(!$distance){
            return null;
        }

        DistanciaCepCd::updateOrCreate(
            [
                'cep' => $cep->cep,
                'endereco_id' => $endereco->id
            ],
            ['distancia' => $distance[0][0]]
        );

        return $distance[0][0];
    }
}
