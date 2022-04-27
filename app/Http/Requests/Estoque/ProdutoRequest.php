<?php

namespace App\Http\Requests\Estoque;

use App\Rules\UniqueDominio;
use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id') ?? 0;

        return [
            'codigo' => ['alpha_dash', 'nullable', 'max:20', new UniqueDominio('produtos', 'codigo', $id)],
            'nome' => 'string|required|min:3|max:50',
            'descricao' => 'string|required|min:20|max:1000',
            'marca_id' => 'integer|required|exists:marcas,id',
            'tipo_produto_id' => 'integer|required|exists:tipos_produto,id',
            'categoria_id' => 'integer|required|exists:categorias,id',
            'icms_padrao' => 'nullable|numeric|min:0|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'codigo' => 'Código',
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'marca_id' => 'Marca',
            'tipo_produto_id' => 'Tipo de Produto',
            'categoria_id' => 'Categoria',
            'icms_padrao' => 'ICMS Padrão',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('codigo')) {
            $this->merge(['codigo' => mb_strtoupper($this->input('codigo'))]);
        }
    }
}
