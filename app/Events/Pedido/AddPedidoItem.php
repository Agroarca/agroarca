<?php

namespace App\Events\Pedido;

use App\Models\Pedidos\PedidoItem;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddPedidoItem
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $pedidoItem;
    public function __construct(PedidoItem $item)
    {
        $this->pedidoItem = $item;
    }
}
