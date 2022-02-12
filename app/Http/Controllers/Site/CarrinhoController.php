<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\Site\PedidoService;

class CarrinhoController extends Controller
{
    public function inicio()
    {
        $pedido = PedidoService::getPedido();
        return view('site.carrinho.carrinho', compact('pedido'));
    }
}
