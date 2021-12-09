@php
    use \App\Helpers\Formatter;
@endphp

<x-admin>
    <x-slot name='header'>
        <div class="row">
            <div class="col-sm-8">
                <h1>Itens da Lista: {{ $listaPreco->nome }}</h1>
            </div>
            <div class="col-sm-4 pt-3 pt-sm-0">
                <a href="{{ route('admin.pedidos.listas_preco.itens.criar', [$listaPreco->id]) }}" class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i>Novo Item</a>
            </div>
        </div>
    </x-slot>

    <div class="card card-default">
        <div class="card-body table-responsive p-0">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Produto</th>
                    <th>Estoque Vendido</th>
                    <th>Estoque Disponível</th>
                    <th>Preço por KG.</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach ($itensListaPreco as $item)
                        <tr>
                            <td>{{ $item->produto->nome }}</td>
                            <td>{{ $item->estoque_vendido }}</td>
                            <td>{{ $item->estoque_disponivel }}</td>
                            <td>{{ Formatter::preco($item->preco_quilo) }}</td>
                            <td>
                                <a href="{{ route('admin.pedidos.listas_preco.itens.editar', [$listaPreco->id, $item->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.pedidos.listas_preco.itens.excluir', [$listaPreco->id, $item->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Excluir">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $itensListaPreco->links() }}
</x-admin>
