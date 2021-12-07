@php
    use \App\Helpers\Formatter;
@endphp

<x-admin>
    <x-slot name='header'>
        <div class="row">
            <div class="col-sm-8">
                <h1>Listas de Preço</h1>
            </div>
            <div class="col-sm-4 pt-3 pt-sm-0">
                <a href="{{ route('admin.pedidos.listas_preco.criar') }}" class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i>Nova Lista</a>
            </div>
        </div>
    </x-slot>

    <div class="card card-default">
        <div class="card-body table-responsive p-0">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Nome</th>
                    <th class="d-none d-md-table-cell">Data</th>
                    <th>Data Início</th>
                    <th>Data Fim</th>
                    <th class="d-none d-md-table-cell">Ajuste Mensal</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach ($listasPreco as $listaPreco)
                        <tr>
                            <td>{{ $listaPreco->nome }}</td>
                            <td class="d-none d-md-table-cell">{{ Formatter::date($listaPreco->data) }}</td>
                            <td>{{ Formatter::datetime($listaPreco->data_inicio) }}</td>
                            <td>{{ Formatter::datetime($listaPreco->data_fim) }}</td>
                            <td class="d-none d-md-table-cell">{{ $listaPreco->ajuste_mensal }} %</td>
                            <td>
                                <a href="{{ route('admin.pedidos.listas_preco.editar', [$listaPreco->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.pedidos.listas_preco.excluir', [$listaPreco->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Excluir">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $listasPreco->links() }}
</x-admin>
