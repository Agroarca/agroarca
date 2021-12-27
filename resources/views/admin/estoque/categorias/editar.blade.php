@php
    use \App\Models\Estoque\Categoria;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Editar categoria {{ $categoria->nome }}</h1>
    </x-slot>

    <form action="{{ route('admin.estoque.categorias.atualizar', $categoria->id) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ $categoria->nome }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="categoria_mae_id">Categoria Mãe:</label>
                    <x-admin.select name='categoria_mae_id' :values="Categoria::pluck('nome', 'id')->toArray()" :selected="$categoria->categoria_mae_id" placeholder="Nenhuma Categoria" :selectPlaceholder="true" :class="['form-control', 'is-invalid' => $errors->has('categoria_mae_id')]"></x-admin.select>
                    <x-admin.form-error property='categoria_mae_id'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>
</x-admin>
