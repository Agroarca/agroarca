<x-admin>
    <x-slot name='header'>
        <h1>Novo Domínio</h1>
    </x-slot>
    <form action="{{ route('admin.administracao.dominios.salvar') }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" @class(['form-control', 'is-invalid'=> $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="dominio">Domínio:</label>
                    <input type="text" name="dominio" value="{{ old('dominio') }}" @class(['form-control', 'is-invalid'=> $errors->has('dominio')]) />
                    <x-admin.form-error property='dominio'></x-admin.form-error>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
