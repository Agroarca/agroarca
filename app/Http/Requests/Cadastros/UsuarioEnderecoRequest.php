<?php

namespace App\Http\Requests\Cadastros;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioEnderecoRequest extends FormRequest
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
            'nome' => 'string|required|min:3|max:100',
            'endereco' => 'string|required|min:3|max:100',
            'bairro' => 'string|required|min:3|max:100',
            'complemento' => 'string|nullable|min:3|max:100',
            'numero' => 'string|required|max:20',
            'cep' => 'numeric|required|digits:8',
            'cidade_id' => 'integer|required|exists:cidades,id'
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'endereco' => 'Endereço',
            'bairro' => 'Bairro',
            'complemento' => 'Complemento',
            'numero' => 'Número',
            'cep' => 'CEP',
            'cidade_id' => 'Cidade'
        ];
    }

    protected function prepareForValidation()
    {
        $cep = preg_replace('/\D/', '', (string) $this->input('cep'));
        $attributes['cep'] = $cep;

        $this->merge($attributes);
    }
}
