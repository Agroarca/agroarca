<x-admin>
    <x-slot name='header'>
        <h1>Editar Lote</h1>
    </x-slot>

    <form action="{{ route('admin.estoque.lotes.atualizar', [$produto->id, $lote->id]) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ $lote->nome }}" @class(['form-control', 'is-invalid'=> $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="data_vencimento">Data de Vencimento:</label>
                    <input type="date" name="data_vencimento" step="1" value="{{ $lote->data_vencimento }}" @class(['form-control', 'is-invalid' => $errors->has('data_vencimento')]) />
                    <x-admin.form-error property='data_vencimento'></x-admin.form-error>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </form>
</x-admin>
