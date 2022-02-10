<x-admin>
    <x-slot name='header'>
        <h1>Novo Tipo de Produto</h1>
    </x-slot>
    <form action="{{ route('admin.estoque.tiposProduto.salvar') }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>
                <div class="form-check" data-toggle="tooltip" data-placement="top" title="Mínimo de dias a partir do dia corrente que pode ser selecionada uma data para entrega">
                    <input type="checkbox" name="listavel" value="{{ old('listavel') }}" @class(['form-check-input', 'is-invalid' => $errors->has('listavel')]) />
                    <label for="listavel" class="form-check-label">Listavel</label>
                    <x-admin.form-error property='listavel'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
