<x-admin>
    <x-slot name='header'>
        <div class="row">
            <div class="col-sm-8">
                <h1>Produtos</h1>
            </div>
            <div class="col-sm-4 pt-3 pt-sm-0">
                <a href="{{ route('admin.produtos.produtos.criar') }}" class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i>Novo Produto</a>
            </div>
        </div>
    </x-slot>

    <div class="card card-default">
        <div class="card-body table-responsive p-0">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->codigo }}</td>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $produto->categoria->nome }}</td>
                            <td>
                                <a href="{{ route('admin.produtos.produtos.editar', [$produto->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('admin.produtos.produtos.excluir', [$produto->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Excluir">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $produtos->links() }}
</x-admin>
