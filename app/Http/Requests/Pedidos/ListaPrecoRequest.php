<?php

namespace App\Http\Requests\Pedidos;

use Illuminate\Foundation\Http\FormRequest;

class ListaPrecoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|min:3|max:100',
            'data' => 'required|date',
            'data_inicio' => 'required|date|before:data_fim',
            'data_fim' => 'required|date|after:data_inicio',
            'ajuste_mensal' => 'required|numeric|min:0|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'data' => 'Data',
            'data_inicio' => 'Data de Início',
            'data_fim' => 'Data de Fim',
            'ajuste_mensal' => 'Ajuste Mensal',
        ];
    }
}
