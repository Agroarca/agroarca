<?php

namespace App\Http\Requests\Estoque;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->sanitize();
        $id = $this->route('id') ?? 0;

        return [
            'codigo' => "alpha_dash|nullable|max:20|unique:produtos,codigo,{$id}",
            'nome' => 'string|required|min:3|max:50',
            'descricao' => 'string|required|min:20|max:1000',
            'marca_id' => 'integer|required|exists:marcas,id',
            'tipo_produto_id' => 'integer|required|exists:tipos_produto,id',
            'categoria_id' => 'integer|required|exists:categorias,id'
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
        ];
    }

    public function sanitize(){
        if($this->has('codigo')){
            $this->merge(['codigo' => mb_strtoupper($this->input('codigo'))]);
        }
    }
}