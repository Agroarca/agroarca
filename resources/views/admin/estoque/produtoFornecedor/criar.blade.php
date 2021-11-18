@php
    use \App\Models\Estoque\Produto;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Novo Produto Ofertado</h1>
    </x-slot>
    <form action="{{ route('admin.estoque.produtoFornecedor.salvar') }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="produto_id">Produto:</label>
                    <x-admin.select name='produto_id' :values="Produto::pluck('nome', 'id')->toArray()" :selected="old('produto_id')" placeholder="Selecione o Produto" :class="['form-control', 'is-invalid' => $errors->has('produto_id')]"></x-admin.select>
                    <x-admin.form-error property='produto_id'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="estoque_disponivel"  data-toggle="tooltip" data-placement="top" title="Estoque total que pode ser vendido, deixe em branco para não ter limite"><i class="fas fa-info-circle"></i> Estoque Disponível (Kg):</label>
                    <input type="text" name="estoque_disponivel" value="{{ old('estoque_disponivel') }}" @class(['form-control', 'is-invalid' => $errors->has('estoque_disponivel')]) />
                    <x-admin.form-error property='estoque_disponivel'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
