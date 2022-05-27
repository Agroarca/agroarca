@php
use \App\Models\Produtos\Marca;
use \App\Models\Produtos\TipoProduto;
use \App\Models\Produtos\Categoria;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Novo Produto</h1>
    </x-slot>
    <form action="{{ route('admin.produtos.produtos.salvar') }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="codigo">Código:</label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}" @class(['form-control', 'is-invalid'=> $errors->has('codigo')]) />
                    <x-admin.form-error property='codigo'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" @class(['form-control', 'is-invalid'=> $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="marca_id">Marca:</label>
                    <x-admin.select name='marca_id' :values="Marca::pluck('nome', 'id')" :selected="old('marca_id')" placeholder="Selecione uma Marca" :class="['form-control', 'is-invalid' => $errors->has('marca_id')]"></x-admin.select>
                    <x-admin.form-error property='marca_id'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="tipo_produto_id">Tipo de Produto:</label>
                    <x-admin.select name='tipo_produto_id' :values="TipoProduto::pluck('nome', 'id')" :selected="old('tipo_produto_id')" placeholder="Selecione um Tipo de Produto" :class="['form-control', 'is-invalid' => $errors->has('tipo_produto_id')]"></x-admin.select>
                    <x-admin.form-error property='tipo_produto_id'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="categoria_id">Categoria:</label>
                    <x-admin.select name='categoria_id' :values="Categoria::pluck('nome', 'id')" :selected="old('categoria_id')" placeholder="Selecione uma Categoria" :class="['form-control', 'is-invalid' => $errors->has('categoria_id')]"></x-admin.select>
                    <x-admin.form-error property='categoria_id'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" rows="5" maxlength="1000" @class(['form-control', 'is-invalid'=> $errors->has('descricao')])>{{ old('descricao') }}</textarea>
                    <x-admin.form-error property='descricao'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="descricao_longa">Descrição Longa:</label>
                    <textarea name="descricao_longa" rows="15" @class(['form-control', 'is-invalid'=> $errors->has('descricao_longa')])>{{ old('descricao_longa') }}</textarea>
                    <x-admin.form-error property='descricao_longa'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
