<x-admin>
    <x-slot name='header'>
        <h1>Administradores</h1>
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $usuarios->links() }}
</x-admin>
