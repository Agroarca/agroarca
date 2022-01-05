<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoPrecoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cep' => 'numeric|required|digits:8'
        ];
    }

    protected function prepareForValidation()
    {
        $cep = preg_replace('/\D/', '', (string) $this->input('cep'));
        $attributes['cep'] = $cep;

        $this->merge($attributes);
    }
}
