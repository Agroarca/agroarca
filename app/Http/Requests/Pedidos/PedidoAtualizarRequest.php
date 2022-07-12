<?php

namespace App\Http\Requests\Pedidos;

use App\Enums\Pedidos\TipoPedido;
use App\Models\Pedidos\Pedido;
use App\Rules\ExistsDominio;
use App\Rules\ExistsUsuarioDominio;
use Illuminate\Foundation\Http\FormRequest;

class PedidoAtualizarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'usuario_id' => ['bail', 'nullable', new ExistsUsuarioDominio()],
            'forma_pagamento_id' => ['bail', 'nullable', new ExistsDominio('formas_pagamento')],
            'data_pagamento' => 'bail|nullable|date',
            'endereco_id' => 'bail|nullable|exists:usuario_enderecos,id',
            'data_entrega' => 'bail|nullable|date',
            'observacao' => 'bail|nullable|string',
        ];
    }
    public function attributes()
    {
        return [
            'tipo' => 'Tipo',
            'usuario_id' => 'Usuário',
            'forma_pagamento_id' => 'Forma de Pagamento',
            'data_pagamento' => 'Data de Pagamento',
            'endereco_id' => 'Endereço de Entrega',
            'data_entrega' => 'Data de Entrega',
            'observacao' => 'Observação'
        ];
    }
}
