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
                </thead>
                <tbody>
                    @foreach ($estados as $estado)
                        <tr>
                            <td>{{ $estado->nome }}</td>
                            <td>{{ $estado->uf }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $estados->links() }}
</x-admin>
