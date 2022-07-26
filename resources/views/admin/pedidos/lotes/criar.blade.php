<x-admin>
    <x-slot name='header'>
            <h1>Novo Lote</h1>
    </x-slot>

    <form action="{{ route('admin.pedidos.pedidos.itens.lotes.salvar', $pedidoItemId) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" @class(['form-control', 'is-invalid'=> $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="data_vencimento">Data de Vencimento:</label>
                    <input type="date" name="data_vencimento" step="1" value="{{ old('data_vencimento') }}" @class(['form-control', 'is-invalid' => $errors->has('data_vencimento')]) />
                    <x-admin.form-error property='data_vencimento'></x-admin.form-error>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
