@php
use \App\Models\Cadastros\Estado;
@endphp
@section('select2', true)

<x-admin>
    <x-slot name='header'>
        <h1>Nova Cidade</h1>
    </x-slot>
    <form action="{{ route('admin.cadastros.cidades.salvar') }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" @class(['form-control', 'is-invalid'=>
                    $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="estado_id">Estado:</label>
                    <x-admin.select2 name='estado_id' :values="Estado::selectTodos()" :selected="old('estado_id')"
                        placeholder="Selecione um Estado"
                        :class="['form-control', 'select2', 'is-invalid' => $errors->has('estado_id')]">
                    </x-admin.select2>
                    <x-admin.form-error property='estado_id'></x-admin.form-error>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
