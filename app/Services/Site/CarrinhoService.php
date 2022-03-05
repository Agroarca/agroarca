<?php

namespace App\Services\Site;

class CarrinhoService
{
    public static function getPedidoItens()
    {
        $pedido = PedidoService::getPedido();
        return $pedido->pedidoItens()->whereNull('pedido_item_pai_id')->get();
    }
}
