<?php

namespace App\Http\Requests\Pedidos;

use App\Rules\ExistsDominio;
use Illuminate\Foundation\Http\FormRequest;

class PedidoItemLoteMovimentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lote_id' => ['bail', 'required', 'integer', new ExistsDominio('lotes')],
            'quantidade' => 'required|integer',
            'operacao' => 'required|integer|between:0,1'
        ];
    }

    public function attributes()
    {
        return [
            'lote_id' => 'Lote',
            'quantidade' => 'Quantidade',
            'operacao' => 'Operacao'
        ];
    }
}
