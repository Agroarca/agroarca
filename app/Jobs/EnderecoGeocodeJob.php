<?php

namespace App\Jobs;

use App\Services\DistanciasService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;

class EnderecoGeocodeJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;

    private $endereco;

    public function __construct(Model $endereco)
    {
        $this->endereco = $endereco->withoutRelations();
    }

    public function uniqueId()
    {
        return $this->endereco->getTable() . $this->endereco->id;
    }

    public function handle()
    {
        DistanciasService::atualizarPlaceId($this->endereco, true);
    }
}
