<x-admin>
    <x-slot name='header'>
        <div class="row">
            <div class="col-sm-8">
                <h1>Tipos de Produto</h1>
            </div>
            <div class="col-sm-4 pt-3 pt-sm-0">
                <a href="{{ route('admin.produtos.tiposProduto.criar') }}" class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i>Novo Tipo</a>
            </div>
        </div>
    </x-slot>

    <div class="card card-default">
        <div class="card-body table-responsive p-0">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Nome</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach ($tiposProduto as $tipoProduto)
                        <tr>
                            <td>{{ $tipoProduto->nome }}</td>
                            <td>
                                <a href="{{ route('admin.produtos.tiposProduto.editar', [$tipoProduto->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.produtos.tiposProduto.excluir', [$tipoProduto->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Excluir">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $tiposProduto->links() }}
</x-admin>
