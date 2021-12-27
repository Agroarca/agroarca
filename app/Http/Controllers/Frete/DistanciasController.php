<?php

namespace App\Http\Controllers\Frete;

use App\Http\Controllers\Api\GoogleDistanceMatrixController;
use App\Http\Controllers\Controller;
use App\Models\Cadastros\UsuarioEndereco;
use Exception;
use InvalidArgumentException;

class DistanciasController extends Controller
{
    public function calcularDistancia(UsuarioEndereco $origem, UsuarioEndereco $destino){
        if(!$origem->google_place_id){
            throw new InvalidArgumentException("Endereço de origem não tem Place Id");
        }

        if(!$destino->google_place_id){
            throw new InvalidArgumentException("Endereço de destino não tem Place Id");
        }

        $distanceController = new GoogleDistanceMatrixController();
        $distance = $distanceController->consultar([$origem->google_place_id], [$destino->google_place_id]);

        if(!$distance){
            throw new Exception("Não foi possível consultar as distâncias na Api do Google");
        }

        return $distance[0][0];

    }
}
