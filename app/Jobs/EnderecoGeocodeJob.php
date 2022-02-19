<?php

namespace App\Jobs;

use App\Models\Cadastros\UsuarioEndereco;
use App\Services\Site\DistanciasService;
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

    public function uniqueId()
    {
        return $this->endereco->id;
    }

    public function handle()
    {
        DistanciasService::verificarAtualizarPlaceId($this->endereco);
    }
}
