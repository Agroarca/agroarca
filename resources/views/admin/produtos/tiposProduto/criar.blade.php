<x-admin>
    <x-slot name='header'>
        <h1>Novo Tipo de Produto</h1>
    </x-slot>
    <form action="{{ route('admin.produtos.tiposProduto.salvar') }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="listavel" value="1" {{ old('listavel') ? 'checked' : '' }} @class(['form-check-input', 'is-invalid' => $errors->has('listavel')]) />
                    <label for="listavel" class="form-check-label">Listavel</label>
                    <x-admin.form-error property='listavel'></x-admin.form-error>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="controlar_estoque" value="1" {{ old('controlar_estoque')?? true ? 'checked' : '' }} @class(['form-check-input', 'is-invalid' => $errors->has('controlar_estoque')]) />
                    <label for="controlar_estoque" class="form-check-label">Controlar Estoque</label>
                    <x-admin.form-error property='controlar_estoque'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
