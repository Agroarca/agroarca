<?php

namespace App\Http\Requests\Cadastros;

use App\Rules\CNPJ;
use App\Rules\Telefone;
use App\Rules\UniqueDominio;
use Illuminate\Foundation\Http\FormRequest;

class CentroDistribuicaoRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'nome' => 'string|required|min:3|max:100',
            'representante' => 'string|required|min:3|max:255',
            'cnpj' => ['bail', 'nullable', new UniqueDominio('centros_distribuicao', null, $id), new CNPJ],
            'telefone' => ['bail', 'nullable', new Telefone],
            'inscricao_estadual' => 'nullable|string|min:3|max:12',
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
            'representante' => 'Representante',
            'cnpj' => 'CNPJ',
            'telefone' => 'Telefone',
            'inscricao_estadual' => 'Inscrição Estadual',
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
        $this->merge([
            'cnpj' => preg_replace('/\D/', '', $this->input('cnpj')),
            'telefone' => preg_replace('/\D/', '', $this->input('telefone')),
            'cep' => preg_replace('/\D/', '', (string) $this->input('cep'))
        ]);
    }
}
