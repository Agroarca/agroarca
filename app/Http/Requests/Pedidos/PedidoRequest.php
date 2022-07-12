<?php

namespace App\Http\Requests\Pedidos;

use App\Enums\Pedidos\TipoPedido;
use App\Models\Pedidos\Pedido;
use App\Rules\ExistsUsuarioDominio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory;

class PedidoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $pedido = Pedido::find($this->route('id'));

        if (!is_null($pedido) && !is_null($pedido->usuario_id)) {
            $validacaoUsuario = ['prohibited'];
        } else {
            $validacaoUsuario = ['bail', 'nullable', new ExistsUsuarioDominio()];
        }

        return [
            'tipo' => 'bail|required|in:' . implode(',', array_keys(TipoPedido::asArray())),
            'usuario_id' => $validacaoUsuario
        ];
    }
    public function attributes()
    {
        return [
            'tipo' => 'Tipo',
            'usuario_id' => 'Usuário',
        ];
    }
}
