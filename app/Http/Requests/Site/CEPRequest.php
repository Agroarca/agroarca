<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class CEPRequest extends FormRequest
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
            'cep' => 'numeric|required|digits:8',
        ];
    }

    public function attributes()
    {
        return [
            'cep' => 'CEP',
        ];
    }

    protected function prepareForValidation()
    {
        $cep = preg_replace('/\D/', '', (string) $this->input('cep'));
        $attributes['cep'] = $cep;

        $this->merge($attributes);
    }
}
