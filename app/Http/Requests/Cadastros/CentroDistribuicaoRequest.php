<?php

namespace App\Http\Requests\Cadastros;

use App\Rules\CNPJ;
use App\Rules\Telefone;
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
            'cnpj' => ['bail', 'nullable', "unique:fornecedor_centros_distribuicao,cnpj,{$id}", new CNPJ],
            'telefone' => ['bail', 'nullable', new Telefone],
            'inscricao_estadual' => 'nullable|string|min:3|max:12',
            'usuario_endereco_id' => 'integer|required|exists:usuario_enderecos,id'
        ];
    }
}
