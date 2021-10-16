<x-admin>
    <x-slot name='header'>
        <h1>Estados</h1>
    </x-slot>

    <div class="card card-default">
        <div class="card-body table-responsive p-0">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Nome</th>
                    <th>UF</th>
                    <th>ICMS</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach ($estados as $estado)
                        <tr>
                            <td>{{ $estado->nome }}</td>
                            <td>{{ $estado->uf }}</td>
                            <td>{{ $estado->icms }} %</td>
                            <td>
                                <a href="{{ route('admin.cadastros.estados.editar', [$estado->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $estados->links() }}
</x-admin>
