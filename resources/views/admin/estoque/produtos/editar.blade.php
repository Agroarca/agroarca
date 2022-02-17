@php
    use \App\Models\Estoque\Marca;
    use \App\Models\Estoque\TipoProduto;
    use \App\Models\Estoque\Categoria;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Editar Produto {{ $produto->nome }}</h1>
    </x-slot>

    @if(count($pendencias))
        <div class="alert alert-warning">
            @foreach ($pendencias as $pendencia)
                <span>{{ $pendencia }}</span><br>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.estoque.produtos.atualizar', $produto->id) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="codigo">Código:</label>
                    <input type="text" name="codigo" value="{{ $produto->codigo }}" @class(['form-control', 'is-invalid'=> $errors->has('codigo')]) />
                    <x-admin.form-error property='codigo'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ $produto->nome }}" @class(['form-control', 'is-invalid'=> $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="marca_id">Marca:</label>
                    <x-admin.select2 name='marca_id' :values="Marca::pluck('nome', 'id')" :selected="$produto->marca_id" placeholder="Selecione uma Marca" :class="['form-control', 'select2', 'is-invalid' => $errors->has('marca_id')]">
                    </x-admin.select2>
                    <x-admin.form-error property='marca_id'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="tipo_produto_id">Tipo de Produto:</label>
                    <x-admin.select2 name='tipo_produto_id' :values="TipoProduto::pluck('nome', 'id')" :selected="$produto->tipo_produto_id" placeholder="Selecione um Tipo de Produto" :class="['form-control', 'select2', 'is-invalid' => $errors->has('tipo_produto_id')]">
                    </x-admin.select2>
                    <x-admin.form-error property='tipo_produto_id'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="categoria_id">Categoria:</label>
                    <x-admin.select2 name='categoria_id' :values="Categoria::pluck('nome', 'id')" :selected="$produto->categoria_id" placeholder="Selecione uma Categoria" :class="['form-control', 'select2', 'is-invalid' => $errors->has('categoria_id')]">
                    </x-admin.select2>
                    <x-admin.form-error property='categoria_id'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" rows="5" maxlength="1000" @class(['form-control', 'is-invalid'=> $errors->has('descricao')])>{{ $produto->descricao }}</textarea>
                    <x-admin.form-error property='descricao'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="descricao_longa">Descrição Longa:</label>
                    <textarea name="descricao_longa" rows="15" @class(['form-control', 'is-invalid'=> $errors->has('descricao_longa')])>{{ $produto->descricao_longa }}</textarea>
                    <x-admin.form-error property='descricao_longa'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>

    @include('admin.estoque.produtos.icms', ['produto' => $produto])
    @include('admin.estoque.produtos.imagens', ['produto' => $produto])
</x-admin>
