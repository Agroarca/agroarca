<?php

namespace App\Services;

use App\Classes\Interfaces\GoogleGeocoding;
use App\Models\Cadastros\UsuarioEndereco;
use App\Models\Frete\Cep;
use App\Models\Frete\DistanciaCepCd;
use App\Models\Frete\DistanciaEndereco;
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
        self::verificarAtualizarPlaceId($origem);
        self::verificarAtualizarPlaceId($destino);

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
        self::verificarAtualizarPlaceId($cep);
        return $cep;
    }

    public static function verificarAtualizarPlaceId($model)
    {
        if ($model->google_place_id) {
            $updated = $model->google_place_id_updated;
            if (Carbon::now()->diffInDays($updated, true) < self::placeIdRefresh()) {
                return;
            }
        }

        if ($model instanceof Cep) {
            $retorno = GoogleGeocodingService::consultarCEP($model->cep);
        } else if ($model instanceof UsuarioEndereco) {
            $endereco = new GoogleGeocoding($model->endereco, $model->numero, $model->cep);
            $retorno = GoogleGeocodingService::consultarEndereco($endereco);
        }

        if ($retorno) {
            $model->google_place_id = $retorno->placeId;
            $model->latitude = $retorno->latitude;
            $model->longitude = $retorno->longitude;
            $model->save();
        }
    }

    private static function consultarDistancia($origem, $destino)
    {
        if ($origem instanceof Cep && $destino instanceof UsuarioEndereco) {
            return self::consultarDistanciaCepEndereco($origem, $destino);
        }

        if ($origem instanceof UsuarioEndereco && $destino instanceof UsuarioEndereco) {
            return self::consultarDistanciaEnderecos($origem, $destino);
        }
    }

    private static function consultarDistanciaEnderecos(UsuarioEndereco $origem, UsuarioEndereco $destino)
    {
        $endereco = DistanciaEndereco::where('endereco_origem_id', $origem->id)
            ->where('endereco_destino_id', $destino->id)
            ->where('updated_at', '>', Carbon::now()->subDays(self::placeIdRefresh()))
            ->first();

        if ($endereco) {
            return $endereco->distancia;
        }

        $distance = GoogleDistanceMatrixService::consultar([$origem->google_place_id], [$destino->google_place_id]);

        if (!$distance) {
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

    private static function consultarDistanciaCepEndereco(Cep $cep, UsuarioEndereco $endereco)
    {
        $distancia = DistanciaCepCd::where('cep', $cep->cep)
            ->where('endereco_id', $endereco->id)
            ->where('updated_at', '>', Carbon::now()->subDays(self::placeIdRefresh()))
            ->first();

        if ($distancia) {
            return $distancia->distancia;
        }

        $distance = GoogleDistanceMatrixService::consultar([$cep->google_place_id], [$endereco->google_place_id]);

        if (!$distance) {
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
