@php
    use App\Enums\Pedidos\ModalidadeFormaPagamento;
    use App\Enums\Pedidos\TipoFormaPagamento;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Editar Forma de Pagamento {{ $formaPagamento->nome }}</h1>
    </x-slot>

    <form action="{{ route('admin.pedidos.formas_pagamento.atualizar', $formaPagamento->id) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ $formaPagamento->nome }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo:</label>
                    <x-admin.select name='tipo' :values="TipoFormaPagamento::$customNames" :selected="TipoFormaPagamento::$customNames[$formaPagamento->tipo]" placeholder="Selecione um Tipo" :class="['form-control', 'is-invalid' => $errors->has('tipo')]"></x-admin.select>
                    <x-admin.form-error property='tipo'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="modalidade">Modalidade:</label>
                    <span class="alert alert-primary d-block" role="alert">
                        À Vista: Impede o seguimento do pedido até o pagamento ser concluído.<br>
                        Crédito: O pedido segue com a emissão da Nota Fiscal e Entrega mesmo sem ter o pagamento concluído.
                    </span>
                    <x-admin.select name='modalidade' :values="ModalidadeFormaPagamento::$customNames" :selected="ModalidadeFormaPagamento::$customNames[$formaPagamento->modalidade]" placeholder="Selecione uma Modalidade" :class="['form-control', 'is-invalid' => $errors->has('modalidade')]"></x-admin.select>
                    <x-admin.form-error property='modalidade'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>
</x-admin>
