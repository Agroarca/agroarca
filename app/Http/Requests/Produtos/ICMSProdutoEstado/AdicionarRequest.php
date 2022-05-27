<?php

namespace App\Http\Requests\Produtos\ICMSProdutoEstado;

use Illuminate\Foundation\Http\FormRequest;

class AdicionarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'icms' => 'required|numeric|min:0|max:100',
            'estado_id' => 'integer|required|exists:estados,id',
            'produto_id' => 'integer|required|exists:produtos,id'
        ];
    }

    public function attributes()
    {
        return [
            'icms' => 'ICMS',
            'estado_id' => 'Estado',
        ];
    }

    protected function prepareForValidation()
    {
        $produtoId = $this->route('produto_id');
        $this->merge([
            'produto_id' => $produtoId
        ]);
    }
}
