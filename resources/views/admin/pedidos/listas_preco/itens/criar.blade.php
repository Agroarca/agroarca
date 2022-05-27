@php
    use \App\Models\Produtos\Produto;
    use \App\Models\Cadastros\CentroDistribuicao;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Novo Item</h1>
    </x-slot>
    <form action="{{ route('admin.pedidos.listas_preco.itens.salvar', [$listaPreco->id]) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <input type="hidden" name="lista_preco_id" value="{{ $listaPreco->id }}">
                <div class="form-group">
                    <label for="produto_id">Produto:</label>
                    <x-admin.select name='produto_id' :values="Produto::pluck('nome', 'id')->toArray()" :selected="old('produto_id')" placeholder="Selecione o Produto" :class="['form-control', 'is-invalid' => $errors->has('produto_id')]"></x-admin.select>
                    <x-admin.form-error property='produto_id'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="centro_distribuicao_id">Centro de Distribuição:</label>
                    <x-admin.select name='centro_distribuicao_id' :values="CentroDistribuicao::all()->pluck('nome', 'id')->toArray()" :selected="old('centro_distribuicao_id')" placeholder="Selecione o Centro de Distribuição" :class="['form-control', 'is-invalid' => $errors->has('centro_distribuicao_id')]"></x-admin.select>
                    <x-admin.form-error property='centro_distribuicao_id'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="estoque_disponivel"  data-toggle="tooltip" data-placement="top" title="Estoque total que pode ser vendido, deixe em branco para não ter limite"><i class="fas fa-info-circle"></i> Estoque Disponível (Kg):</label>
                    <input type="text" name="estoque_disponivel" value="{{ old('estoque_disponivel') }}" @class(['form-control mask-quilo', 'is-invalid' => $errors->has('estoque_disponivel')]) />
                    <x-admin.form-error property='estoque_disponivel'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="preco_quilo">Preço por Kg.:</label>
                    <input type="text" name="preco_quilo" value="{{ old('preco_quilo') }}" @class(['form-control mask-preco', 'is-invalid' => $errors->has('preco_quilo')]) />
                    <x-admin.form-error property='preco_quilo'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="base_frete" data-toggle="tooltip" data-placement="top" title="Valor base do cálculo do frete. o cálculo será o Valor de Base * A quantidade em Kg do produto * Distância em Km"><i class="fas fa-info-circle"></i> Base do Frete (por Kg por Km):</label>
                    <input type="text" name="base_frete" value="{{ old('base_frete') }}" @class(['form-control mask-preco', 'is-invalid' => $errors->has('base_frete')]) />
                    <x-admin.form-error property='base_frete'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
