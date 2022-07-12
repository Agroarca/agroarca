<?php

namespace App\Http\Requests\Pedidos;

use App\Enums\Pedidos\TipoPedido;
use App\Models\Pedidos\Pedido;
use App\Rules\ExistsDominio;
use Illuminate\Foundation\Http\FormRequest;

class PedidoitemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        $rules = [
            'quantidade' => 'required|numeric',
            'preco_quilo' => 'required|numeric',
            'frete' => 'nullable|numeric',
            'icms' => 'nullable|numeric',
        ];

        if (is_null($id)) {
            $rules['produto_id'] = 'required|numeric';
        }

        return $rules;
    }
}
