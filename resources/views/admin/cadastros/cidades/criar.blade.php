@php
    use \App\Models\Cadastros\Estado;
@endphp

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
                    <input type="text" name="nome" value="{{ old('nome') }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    @foreach ($errors->get('nome') as $error)
                        <span class="error invalid-feedback">{{ $error }}</span>
                    @endforeach
                </div>

                <div class="form-group">
                    <label for="estado_id">Estado:</label>
                    <select id="estado_id" name="estado_id" @class(['form-control', 'is-invalid' => $errors->has('estado_id')]) >

                        <option disabled {{ empty(old('estado_id')) ? 'selected' : '' }}>
                            Selecione um Estado
                        </option>

                        @foreach (Estado::all() as $estado)
                            <option value="{{ $estado->id }}" {{ old('estado_id') == $estado->id ? 'selected' : '' }}>
                                {{ $estado->uf }} - {{ $estado->nome }}
                            </option>
                        @endforeach

                    </select>
                    @foreach ($errors->get('estado_id') as $error)
                        <span class="error invalid-feedback">
                            {{ $error }}
                        </span>
                    @endforeach
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>

    </form>
</x-admin>
