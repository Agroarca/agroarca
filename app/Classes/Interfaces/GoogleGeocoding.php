<?php

namespace App\Classes\Interfaces;

class GoogleGeocoding
{
    public $endereco;
    public $numero;
    public $cep;

    public function __construct($endereco, $numero, $cep){
        $this->endereco = $endereco;
        $this->numero = $numero;
        $this->cep = $cep;
    }
}
