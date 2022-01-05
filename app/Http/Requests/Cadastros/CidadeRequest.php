<?php

namespace App\Http\Requests\Cadastros;

use Illuminate\Foundation\Http\FormRequest;

class CidadeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'bail|required|string|min:3|max:100',
            'estado_id' => 'integer|required|exists:estados,id'
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'estado_id' => 'Estado',
        ];
    }
}
