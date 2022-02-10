<?php

namespace App\Http\Requests\Estoque;

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
            'listavel' => 'boolean|required',
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
        $listavel = $this->input('listavel');
        $this->merge([
            'listavel' => $listavel ?? false
        ]);
    }
}
