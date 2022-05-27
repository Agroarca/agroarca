<?php

namespace App\Http\Requests\Produtos\ICMSProdutoEstado;

use Illuminate\Foundation\Http\FormRequest;

class AtualizarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'icms_padrao' => 'required|numeric|min:0|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'icms_padrao' => 'ICMS Padrão',
        ];
    }
}
