<?php

namespace App\Http\Controllers\Site\Pedido;

use App\Enums\Pedidos\StatusPedido;
use App\Exceptions\OperacaoIlegalException;
use App\Http\Controllers\Controller;
use App\Models\Pedidos\Pedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PedidoController extends Controller
{
    public function getPedido(){
        $pedido = $this->getPedidoCookie();
        if($pedido){
            return $pedido;
        }

        if(Auth::check()){
            $pedido = Pedido::firstOrCreate([
                'status' => StatusPedido::Aberto,
                'usuario_id' => Auth::id()
            ]);
        }else{
            $pedido = Pedido::create();
        }

        $this->setPedidoCookie($pedido);
        return $pedido;
    }

    private function getPedidoCookie(){
        $pedidoId = Cookie::get('pedidoId');

        $pedido = Pedido::find($pedidoId);
        if($pedido){
            $usuarioId = Auth::id();
            if($pedido->usuario_id == $usuarioId){
                return $pedido;
            }
        }

        return null;
    }

    private function setPedidoCookie(Pedido $pedido){
        $pedidoId = Cookie::get('pedidoId');
        if($pedido && $pedido->id != $pedidoId){
            Cookie::queue('pedidoId', $pedido->id);
        }
    }

    public function deletePedido(Pedido $pedido){
        if($pedido->status != StatusPedido::Aberto){
            throw new OperacaoIlegalException("Não é permitido excluir um pedido que não esteja aberto");
        }

        $pedido->pedidoItens()->delete();
        $pedido->delete();
    }
}
