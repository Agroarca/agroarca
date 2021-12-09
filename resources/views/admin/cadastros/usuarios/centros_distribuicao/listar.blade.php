@if (count($centrosDistribuicao) > 0)
    <table class="table table-stripped table-hover">
        <thead>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Cidade</th>
            <th>Ações</th>
        </thead>
        <tbody>
            @foreach ($centrosDistribuicao as $centroDistribuicao)
                <tr>
                    <td>{{ $centroDistribuicao->nome }}</td>
                    <td>{{ $centroDistribuicao->usuarioEndereco->nome }}</td>
                    <td>{{ $centroDistribuicao->usuarioEndereco->cidade->nome }} - {{ $centroDistribuicao->usuarioEndereco->cidade->estado->uf }}</td>
                    <td>
                        <a href="{{ route('admin.cadastros.usuarios.centrosDistribuicao.editar', [$usuario->id, $centroDistribuicao->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a href="{{ route('admin.cadastros.usuarios.centrosDistribuicao.excluir', [$usuario->id, $centroDistribuicao->id]) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Excluir">
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
