<x-admin>
    <x-slot name='header'>
        <div class="row">
            <div class="col-sm-8">
                <h1>Usuarios</h1>
            </div>
            <div class="col-sm-4 pt-3 pt-sm-0">
                <button class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i> Nova Lista de Preço</button>
            </div>
        </div>
    </x-slot>

    <div class="card card-default">
        <div class="card-body table-responsive p-0">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Nome</th>
                    <th class="d-none d-md-table-cell">CPF ou CNPJ</th>
                    <th class="d-none d-md-table-cell">Tipo</th>
                    <th class="d-none d-md-table-cell">Celular</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->nome }}</td>
                            <td class="d-none d-md-table-cell">{{ $usuario->documento }}</td>
                            <td class="d-none d-md-table-cell">{{ $usuario->nomeTipoPessoa }}</td>
                            <td class="d-none d-md-table-cell">{{ $usuario->celularFormatado }}</td>
                            <td>
                                <a href="{{ route('admin.cadastros.usuarios.editar', [$usuario->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $usuarios->links() }}
</x-admin>
