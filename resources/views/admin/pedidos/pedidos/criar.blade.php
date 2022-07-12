<x-admin>
    <x-slot name='header'>
        <h1>Novo Pedido</h1>
    </x-slot>

    <form action="{{ route('admin.pedidos.pedidos.salvar') }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="tipo">Tipo de Produto:</label>
                    <x-admin.select name='tipo' :values="$tiposPedido" :selected="old('tipo')" placeholder="Selecione um Tipo" :class="['form-control', 'is-invalid' => $errors->has('tipo')]"></x-admin.select>
                    <x-admin.form-error property='tipo'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="usuario_id">Usuário:</label>
                    <x-admin.select name='usuario_id' :values="[]" :selected="old('usuario_id')" data-s2-url="{{ route('api.usuarios') }}" placeholder="Selecione um Usuário" :class="['form-control', 'is-invalid' => $errors->has('usuario_id')]"></x-admin.select>
                    <x-admin.form-error property='usuario_id'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
