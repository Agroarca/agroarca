<?php

namespace App\Http\Requests\Pedidos;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Factory;

use Illuminate\Foundation\Http\FormRequest;

class ItemListaPrecoRequest extends FormRequest
{
    public function __construct(Factory $factory)
    {
        $factory->extend(
            'greater_than',
            function ($attribute, $value, $parameters){
                return $value > $parameters[0];
            },
            'O campo :attribute deve ser maior que :greater_than.'
        );

        $factory->replacer('greater_than', function($message, $attribute, $rule, $parameters) {
            return str_replace(':greater_than', $parameters[0], $message);
        });
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'preco_quilo' => 'numeric|required|greater_than:0',
            'estoque_disponivel' => 'integer|nullable|min:0',
            'produto_id' => 'integer|required|exists:produtos,id',
            'lista_preco_id' => 'integer|required|exists:listas_preco,id'
        ];
    }

    public function attributes()
    {
        return [
            'preco_quilo ' => 'Preço por Quilo',
            'estoque_disponivel' => 'Estoque Disponível',
            'produto_id' => 'Produto',
            'lista_preco_id' => 'Lista de Preço',
        ];
    }
}
