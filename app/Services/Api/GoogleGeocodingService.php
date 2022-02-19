<?php

namespace App\Services\Api;

use App\Classes\Interfaces\GoogleGeocoding;
use App\Classes\Interfaces\GoogleGeocodingRetorno;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GoogleGeocodingService
{
    private static function consultar($address)
    {
        $baseUrl = config('agroarca.apis.googleGeocodeBaseUrl');

        $client = new Client([
            'base_uri' => $baseUrl,
            'timeout' => 30,
            'http_errors' => false,
            'query' => [
                'key' => env('GOOGLE_MAPS_API_KEY'),
                'address' => $address
            ]
        ]);

        $response = $client->request('GET');

        if ($response->getStatusCode() != 200) {
            Log::warning("GoogleGeocoding: Erro ao consultar endereço: $address; StatusCode: " . $response->getStatusCode());
            return null;
        }

        $dados = json_decode($response->getBody());
        if ($dados->status == "ZERO_RESULTS") {
            Log::warning("GoogleGeocoding: Retornado ZERO_RESULTS, parâmetros: $address");
            return null;
        }

        if ($dados->status != "OK") {
            Log::error("GoogleGeocoding: Ocorreu um erro ao consultar endereço, status retornado: $dados->status, parâmetros: $address");
            return null;
        }

        $retorno = new GoogleGeocodingRetorno();
        $retorno->placeId = $dados->results[0]->place_id;
        $retorno->latitude = $dados->results[0]->geometry->location->lat;
        $retorno->longitude = $dados->results[0]->geometry->location->lng;
        return $retorno;
    }

    public static function consultarEndereco(GoogleGeocoding $endereco)
    {
        $address = urlencode("$endereco->endereco $endereco->numero") . ";components=postalcode:$endereco->cep";
        return self::consultar($address);
    }

    public static function consultarCEP($cep)
    {
        $address = "$cep Brasil";
        return self::consultar($address);
    }
}
