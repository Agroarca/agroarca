@php
    use App\Models\Produtos\Produto;
    use \App\Helpers\Formatter;
@endphp

<x-admin>
    <x-slot name='header'>
        <div class="row">
            <div class="col-sm-8">
                <h1 class="form-row">
                    <div class="col">
                        <h1>Lotes</h1>
                    </div>
                    <div class="col">
                        <x-admin.select id='produto_id' name='produto_id' :values="Produto::pluck('nome', 'id')->toArray()" :selected="optional($produto)->id" placeholder="Selecione o Produto" class="form-control" onchange="atualizarLista()"></x-admin.select>                    </div>
                </h1>
            </div>
            @if (!is_null($produto))
                <div class="col-sm-4 pt-3 pt-sm-0">
                    <a href="{{ route('admin.estoque.lotes.criar', [optional($produto)->id]) }}" class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i>Novo Lote</a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="card card-default">
        @if (!is_null($produto))
            <div class="card-body table-responsive p-0">
                <table class="table table-stripped table-hover">
                    <thead>
                        <th>Nome</th>
                        <th>Qtd. Disponível</th>
                        <th>Qtd. Total</th>
                        <th>Data de Vencimento</th>
                        <th>Açoes</th>
                    </thead>
                    <tbody>
                        @foreach ($lotes as $lote)
                            <tr>
                                <td>{{ $lote->nome }}</td>
                                <td>{{ $lote->quantidade_disponivel }}</td>
                                <td>{{ $lote->quantidade_total }}</td>
                                <td>{{ Formatter::date($lote->data_vencimento) }}</td>
                                <td>
                                    <a href="{{ route('admin.estoque.lotes.editar', [$produto->id, $lote->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="{{ route('admin.estoque.lotes.excluir', [$produto->id, $lote->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Excluir">
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
                <span>Selecione um Produto</span>
            </div>
        @endif
    </div>

    @if (!is_null($produto))
        {{ $lotes->links() }}
    @endif

    @push('js')
        <script>
            function atualizarLista(){
                let id = $('#produto_id').val();
                window.location = `/admin/estoque/lotes/${id}/`
            }
        </script>
    @endpush
</x-admin>
