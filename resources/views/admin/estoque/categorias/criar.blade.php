@php
    use \App\Models\Estoque\Categoria;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Nova Categoria</h1>
    </x-slot>
    <form action="{{ route('admin.estoque.categorias.salvar') }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="categoria_mae_id">Categoria Mãe:</label>
                    <x-admin.select name='categoria_mae_id' :values="Categoria::pluck('nome', 'id')->toArray()" :selected="old('categoria_mae_id')" placeholder="Nenhuma Categoria" :selectPlaceholder="true" :class="['form-control', 'is-invalid' => $errors->has('categoria_mae_id')]"></x-admin.select>
                    <x-admin.form-error property='categoria_mae_id'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
