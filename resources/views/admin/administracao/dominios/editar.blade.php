<x-admin>
    <x-slot name='header'>
        <h1>Editar domínio {{ $dominio->nome }}</h1>
    </x-slot>

    <form action="{{ route('admin.administracao.dominios.atualizar', $dominio->id) }}" method="POST">
        <div class="card card-default">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ $dominio->nome }}" @class(['form-control', 'is-invalid'=> $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="dominio">Domínio:</label>
                    <input type="text" name="dominio" value="{{ $dominio->dominio }}" @class(['form-control', 'is-invalid'=> $errors->has('dominio')]) />
                    <x-admin.form-error property='dominio'></x-admin.form-error>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>
</x-admin>
