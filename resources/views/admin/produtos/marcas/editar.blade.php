<x-admin>
    <x-slot name='header'>
        <h1>Editar marca {{ $marca->nome }}</h1>
    </x-slot>

    <form action="{{ route('admin.produtos.marcas.atualizar', $marca->id) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ $marca->nome }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    @foreach ($errors->get('nome') as $error)
                        <span class="error invalid-feedback">{{ $error }}</span>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>
</x-admin>
