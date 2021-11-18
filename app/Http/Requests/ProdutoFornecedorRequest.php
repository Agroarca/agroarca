<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProdutoFornecedorRequest extends FormRequest
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
            'estoque_disponivel' => 'integer|nullable|min:0',
            'produto_id' => ['integer', Rule::requiredIf(function(){
                return empty($this->route('id'));
            }), 'exists:produtos,id'],
        ];
    }

    public function attributes()
    {
        return [
            'estoque_disponivel' => 'Estoque Disponível',
            'produto_id' => 'Produto',
        ];
    }
}
