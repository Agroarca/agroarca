@section('InputMask', true)

@php
    use \App\Models\Estoque\Produto;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Novo Item</h1>
    </x-slot>
    <form action="{{ route('admin.pedidos.listas_preco.itens.atualizar', [$listaPreco->id, $itemListaPreco->id]) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <input type="hidden" name="lista_preco_id" value="{{ $listaPreco->id }}">
                <div class="form-group">
                    <input type="hidden" name="produto_id" value="{{ $itemListaPreco->produto_id }}">
                    <label for="produto">Produto:</label>
                    <x-admin.select name='produto' disabled :values="Produto::where('id', $itemListaPreco->produto_id)->pluck('nome', 'id')->toArray()" :selected="$itemListaPreco->produto_id" placeholder="Selecione o Produto" :class="['form-control', 'is-invalid' => $errors->has('produto')]"></x-admin.select>
                    <x-admin.form-error property='produto_id'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="estoque_disponivel"  data-toggle="tooltip" data-placement="top" title="Estoque total que pode ser vendido, deixe em branco para não ter limite"><i class="fas fa-info-circle"></i> Estoque Disponível (Kg):</label>
                    <input type="text" name="estoque_disponivel" value="{{ $itemListaPreco->estoque_disponivel }}" @class(['form-control mask-quilo', 'is-invalid' => $errors->has('estoque_disponivel')]) />
                    <x-admin.form-error property='estoque_disponivel'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="preco_quilo">Preço por Kg.:</label>
                    <input type="text" name="preco_quilo" value="{{ $itemListaPreco->preco_quilo }}" @class(['form-control mask-preco', 'is-invalid' => $errors->has('preco_quilo')]) />
                    <x-admin.form-error property='preco_quilo'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
