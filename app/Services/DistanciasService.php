<?php

namespace App\Services;

use App\Models\Frete\Cep;
use App\Models\Frete\Distancia;
use App\Services\Api\GoogleDistanceMatrixService;
use App\Services\Api\GoogleGeocodingService;
use Carbon\Carbon;
use InvalidArgumentException;
use Exception;

class DistanciasService
{
    private static function placeIdRefresh()
    {
        return config('agroarca.frete.googlePlaceIdRegrashDays');
    }

    /*
    * Calcula a distância em metros entre a $origem e o $destino
    */
    public static function calcularDistancia($origem, $destino)
    {
        self::atualizarPlaceId($origem);
        self::atualizarPlaceId($destino);

        if (!$origem->google_place_id) {
            throw new InvalidArgumentException("Endereço de origem não tem Place Id");
        }

        if (!$destino->google_place_id) {
            throw new InvalidArgumentException("Endereço de destino não tem Place Id");
        }

        $distance = self::consultarDistancia($origem, $destino);

        if (!is_numeric($distance)) {
            throw new Exception("Não foi possível consultar as distâncias na Api do Google");
        }

        return $distance;
    }

    public static function criarCep($nrCep)
    {
        $cep = Cep::firstOrCreate(['cep' => $nrCep]);
        self::atualizarPlaceId($cep);
        return $cep;
    }

    public static function atualizarPlaceId($model, $force = false)
    {
        if ($model->google_place_id && !$force) {
            $updated = $model->google_place_id_updated;
            if (Carbon::now()->diffInDays($updated, true) < self::placeIdRefresh()) {
                return;
            }
        }

        $retorno = GoogleGeocodingService::consultar($model->getConsulta());
        if ($retorno) {
            $model->google_place_id = $retorno->placeId;
            $model->latitude = $retorno->latitude;
            $model->longitude = $retorno->longitude;
            $model->saveQuietly();
        }
    }

    private static function consultarDistancia($origem, $destino)
    {
        $distancia = Distancia::where(function ($query) use ($origem, $destino) {
            $query->where('origem_place_id', $origem->google_place_id)
                ->where('destino_place_id', $destino->google_place_id);
        })->orWhere(function ($query) use ($origem, $destino) {
            $query->where('destino_place_id', $origem->google_place_id)
                ->where('origem_place_id', $destino->google_place_id);
        })->first();

        if ($distancia && $distancia->distancia > 0) {
            return $distancia->distancia;
        }

        $distance = GoogleDistanceMatrixService::consultar([$origem->google_place_id], [$destino->google_place_id]);
        if (!$distance) {
            return null;
        }

        Distancia::updateOrCreate([
            'origem_place_id' => $origem->google_place_id,
            'destino_place_id' => $destino->google_place_id
        ], [
            'distancia' => $distance[0][0]
        ]);

        return $distance[0][0];
    }
}
