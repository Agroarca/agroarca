@if (count($enderecos) > 0)
    <table class="table table-stripped table-hover">
        <thead>
            <th>Nome</th>
            <th>Cep</th>
            <th>Cidade</th>
            <th>Ações</th>
        </thead>
        <tbody>
            @foreach ($enderecos as $endereco)
                <tr>
                    <td>{{ $endereco->nome }}</td>
                    <td>{{ $endereco->cep }}</td>
                    <td>{{ $endereco->cidade->nome }} - {{ $endereco->cidade->estado->uf }}</td>
                    <td>
                        <a href="{{ route('admin.cadastros.usuarios.enderecos.editar', [$usuario->id, $endereco->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                            <i class="fas fa-pen"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
