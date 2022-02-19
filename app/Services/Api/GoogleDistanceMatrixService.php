<?php

namespace App\Services\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GoogleDistanceMatrixService
{
    private static function montarParametro(array $parametros)
    {
        $param = '';

        foreach ($parametros as $parametro) {
            if (strlen($param > 0)) {
                $param .= '|';
            }
            $param .= "place_id:$parametro";
        }

        return $param;
    }

    public static function consultar(array $origens, array $destinos)
    {
        $origemParam = self::montarParametro($origens);
        $destinoParam = self::montarParametro($destinos);

        $client = new Client([
            'base_uri' => config('agroarca.apis.googleDistanceMatrixBaseURL'),
            'timeout' => 30,
            'http_errors' => false,
            'query' => [
                'key' => env('GOOGLE_MAPS_API_KEY'),
                'origins' => $origemParam,
                'destinations' => $destinoParam
            ]
        ]);

        $response = $client->request('GET');

        if ($response->getStatusCode() != 200) {
            Log::warning("GoogleDistanceMatrix: Erro ao consultar endereço: $origemParam / $destinoParam; StatusCode: " . $response->getStatusCode());
            return null;
        }

        $dados = json_decode($response->getBody());
        if ($dados->status != "OK") {
            Log::error("GoogleDistanceMatrix: Ocorreu um erro ao consultar endereço, status retornado: $dados->status, parâmetros: $origemParam / $destinoParam");
            return null;
        }

        $retorno = [];
        for ($i = 0; $i < count($dados->rows); $i++) {

            foreach ($dados->rows[$i]->elements as $element) {
                if ($element->status != 'OK') {
                    Log::error("GoogleDistanceMatrix Element: Ocorreu um erro ao consultar endereço, status retornado: $dados->status, parâmetros: $origemParam / $destinoParam");
                    $retorno[$i][] = null;
                    continue;
                }

                $retorno[$i][] = $element->distance->value;
            }
        }
        return $retorno;
    }
}
