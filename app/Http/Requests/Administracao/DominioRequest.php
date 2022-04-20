<?php

namespace App\Http\Requests\Administracao;

use Illuminate\Foundation\Http\FormRequest;

class DominioRequest extends FormRequest
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
            'nome' => 'required|string|min:3|max:255',
            'dominio' => 'required|string|min:3|max:255'
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'dominio' => 'Domínio',
        ];
    }
}
