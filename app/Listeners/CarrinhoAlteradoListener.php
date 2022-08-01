<?php

namespace App\Listeners;

use App\Events\Site\CarrinhoAlteradoEvent;
use App\Services\Site\PedidoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CarrinhoAlteradoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CarrinhoAlteradoEvent  $event
     * @return void
     */
    public function handle(CarrinhoAlteradoEvent $event)
    {
        $pedido = PedidoService::getPedido();
        $pedido->load([
            'pedidoItens',
            'pedidoItens.itemListaPreco',
            'pedidoItens.itemListaPreco.centroDistribuicao',
            'pedidoItens.pedidoItensAdicionais',
            'endereco',
        ]);
        PedidoService::atualizarQuantidadeCarrinho($pedido);
        PedidoService::calcularPedido($pedido);
        PedidoService::verificarEnderecoPadrao($pedido);
    }
}
