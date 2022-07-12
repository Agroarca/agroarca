<?php

namespace App\Http\Requests\Produtos;

use Illuminate\Foundation\Http\FormRequest;

class TipoProdutoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'string|required|min:3|max:100',
            'listavel' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'listavel' => 'Listavel',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'listavel' => $this->boolean('listavel')
        ]);
    }
}