<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\Pedido\PedidoController;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    public function inicio(){
        $pedidoController = new PedidoController();
        $pedido = $pedidoController->getPedido();

        return view('site.carrinho.carrinho', compact('pedido'));
    }
}
