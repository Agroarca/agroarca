@php
    use \App\Models\Produtos\TipoProduto;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Editar tipo {{ $tipoProduto->nome }}</h1>
    </x-slot>

    <form action="{{ route('admin.produtos.tiposProduto.atualizar', $tipoProduto->id) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ $tipoProduto->nome }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    @foreach ($errors->get('nome') as $error)
                        <span class="error invalid-feedback">{{ $error }}</span>
                    @endforeach
                </div>
                <div class="form-check" data-toggle="tooltip" data-placement="top" title="Mínimo de dias a partir do dia corrente que pode ser selecionada uma data para entrega">
                    <input type="checkbox" name="listavel" value="1" {{ $tipoProduto->listavel ? 'checked' : '' }} @class(['form-check-input', 'is-invalid' => $errors->has('listavel')]) />
                    <label for="listavel" class="form-check-label">Listavel</label>
                    <x-admin.form-error property='listavel'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Tipos de Produto Adicionais</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.produtos.tiposProduto.adicional', $tipoProduto->id) }}" method="POST" class="form-inline">
                @csrf
                <div class="form-group">
                    <label for="tipo_produto_id" class="pr-2">Tipo:</label>
                    <x-admin.select name='tipo_produto_id' :values="$tiposProdutosAdicionais->pluck('nome', 'id')" placeholder="Selecione um Tipo de Produto" :class="['form-control', 'mr-2', 'is-invalid' => $errors->has('tipo_produto_id')]"></x-admin.select>
                    <x-admin.form-error property='tipo_produto_id'></x-admin.form-error>
                </div>
                <button type="submit" class="btn btn-primary">Adicionar</button>
            </form>
            @if(count($tipoProduto->tiposProdutosAdicionais)>0)
                <table class="table table-stripped table-hover">
                    <thead>
                        <th>Nome</th>
                        <th>Ações</th>
                    </thead>
                    <tbody>
                        @foreach ($tipoProduto->tiposProdutosAdicionais as $tipoProdutoAdicional)
                            <tr>
                                <td>{{ $tipoProdutoAdicional->nome }}</td>
                                <td>
                                    <a href="{{ route('admin.produtos.tiposProduto.excluirAdicional', [$tipoProduto->id, $tipoProdutoAdicional->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Excluir">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-admin>
