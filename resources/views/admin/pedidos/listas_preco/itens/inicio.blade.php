@php
    use \App\Helpers\Formatter;
@endphp

<x-admin>
    <x-slot name='header'>
        <div class="row">
            <div class="col-sm-8">
                <h1 class="form-row">
                    <div class="col">
                        Itens da Lista:
                    </div>
                    <div class="col">
                        <x-admin.select name="lista_preco_id" :values="$listasPreco" :selected="optional($listaPreco)->id" placeholder="Selecione uma Lista de Preço" class="form-control" onchange="atualizarLista()"></x-admin.select>
                    </div>
                </h1>
            </div>
            @if (!is_null($listaPreco))
                <div class="col-sm-4 pt-3 pt-sm-0">
                    <a href="{{ route('admin.pedidos.listas_preco.itens.criar', [optional($listaPreco)->id]) }}" class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i>Novo Item</a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="card card-default">
        @if (!is_null($listaPreco))
            <div class="card-body table-responsive p-0">
                <table class="table table-stripped table-hover">
                    <thead>
                        <th>Produto</th>
                        <th class="d-none d-md-table-cell">Centro de Distribuição</th>
                        <th class="d-none d-md-table-cell">Estoque Vendido</th>
                        <th class="d-none d-md-table-cell">Estoque Disponível</th>
                        <th>Preço por KG.</th>
                        <th class="d-none d-md-table-cell">Base do Frete</th>
                        <th>Ações</th>
                    </thead>
                    <tbody>
                        @foreach ($itensListaPreco as $item)
                            <tr>
                                <td>{{ $item->produto->nome }}</td>
                                <td class="d-none d-md-table-cell">{{ $item->centroDistribuicao->nome }}</td>
                                <td class="d-none d-md-table-cell">{{ $item->estoque_vendido }} Kg.</td>
                                <td class="d-none d-md-table-cell">{{ $item->estoque_disponivel }} Kg.</td>
                                <td>{{ Formatter::preco($item->preco_quilo) }}</td>
                                <td class="d-none d-md-table-cell">{{ Formatter::preco($item->base_frete) }}</td>
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
        @else
            <div class="card-body bg-warning">
                <span>Selecione uma Lista de Preço</span>
            </div>
        @endif
    </div>
    @if ($listaPreco)
        {{ $itensListaPreco->links() }}
    @endif

    @push('js')
        <script>
            function atualizarLista(){
                let id = $('#lista_preco_id').val();
                window.location = `/admin/pedidos/listasPreco/${id}/itemListaPreco`
            }
        </script>
    @endpush
</x-admin>

