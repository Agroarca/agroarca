@php
    use App\Enums\Pedidos\ModalidadeFormaPagamento;
    use App\Enums\Pedidos\TipoFormaPagamento;
@endphp

<x-admin>
    <x-slot name='header'>
        <div class="row">
            <div class="col-sm-8">
                <h1>Formas de Pagamento</h1>
            </div>
            <div class="col-sm-4 pt-3 pt-sm-0">
                <a href="{{ route('admin.pedidos.formas_pagamento.criar') }}" class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i>Nova Forma</a>
            </div>
        </div>
    </x-slot>

    <div class="card card-default">
        <div class="card-body table-responsive p-0">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Modalidade</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach ($formasPagamento as $formaPagamento)
                        <tr>
                            <td>{{ $formaPagamento->nome }}</td>
                            <td>{{ TipoFormaPagamento::getName($formaPagamento->tipo) }}</td>
                            <td>{{ ModalidadeFormaPagamento::getName($formaPagamento->modalidade) }}</td>
                            <td>
                                <a href="{{ route('admin.pedidos.formas_pagamento.editar', [$formaPagamento->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.pedidos.formas_pagamento.excluir', [$formaPagamento->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Excluir">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $formasPagamento->links() }}
</x-admin>
