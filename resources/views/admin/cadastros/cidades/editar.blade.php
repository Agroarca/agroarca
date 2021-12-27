@php
    use \App\Models\Cadastros\Estado;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Editar cidade {{ $cidade->nome }}</h1>
    </x-slot>

    <form action="{{ route('admin.cadastros.cidades.atualizar', $cidade->id) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ $cidade->nome }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="estado_id">Estado:</label>
                    <x-admin.select name='estado_id' :values="Estado::selectTodos()" :selected="$cidade->estado_id" :class="['form-control', 'is-invalid' => $errors->has('estado_id')]"></x-admin.select>
                    <x-admin.form-error property='estado_id'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>
</x-admin>
