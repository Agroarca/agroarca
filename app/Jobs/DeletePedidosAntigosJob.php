<?php

namespace App\Jobs;

use App\Enums\Pedidos\StatusPedido;
use App\Models\Pedidos\Pedido;
use App\Services\Site\PedidoService;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DeletePedidosAntigosJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable;

    private $configDias;

    public function __construct()
    {
        $this->configDias =  config('agroarca.pedidos.dias_deletar_abertos');
    }

    public function handle()
    {
        Log::info("DeletePedidosAntigosJob - inicio");

        $data = Carbon::now()->subDays($this->configDias);
        $pedidos = Pedido::where('status', StatusPedido::Aberto)
            ->whereDate('updated_at', '<', $data)
            ->cursor();

        foreach ($pedidos as $pedido) {
            try {
                $this->logStart($pedido);
                PedidoService::deletePedido($pedido);
            } catch (Exception $e) {
                Log::error("DeletePedidosAntigosJob - Ocorreu um erro ao excluir o pedido $pedido->id" . $e);
            }
        }

        Log::info("DeletePedidosAntigosJob - fim");
    }

    private function logStart($pedido)
    {
        Log::info("DeletePedidosAntigosJob - Excluindo o pedido $pedido->id, usuario: $pedido->usuario_id, status: " .
            StatusPedido::getName($pedido->status) . ", updated_at: $pedido->updated_at");
    }
}
