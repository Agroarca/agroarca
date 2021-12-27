@section('InputMask', true)

<x-admin>
    <x-slot name='header'>
        <h1>Editar Lista de Preço {{ $listaPreco->nome }}</h1>
    </x-slot>

    <form action="{{ route('admin.pedidos.listas_preco.atualizar', $listaPreco->id) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ $listaPreco->nome }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="data" data-toggle="tooltip" data-placement="top" title="Data a partir da qual são calculados os juros."><i class="fas fa-info-circle"></i> Data de referência:</label>
                    <input type="date" name="data" value="{{ $listaPreco->data }}" @class(['form-control', 'is-invalid' => $errors->has('data')]) />
                    <x-admin.form-error property='data'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="data_inicio" data-toggle="tooltip" data-placement="top" title="Data que a lista de preço é ativada"><i class="fas fa-info-circle"></i> Data de Início:</label>
                    <input type="datetime-local" name="data_inicio" step="1" value="{{ \Carbon\Carbon::parse($listaPreco->data_inicio)->toDateTimeLocalString() }}" @class(['form-control', 'is-invalid' => $errors->has('data_inicio')]) />
                    <x-admin.form-error property='data_inicio'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="data_fim" data-toggle="tooltip" data-placement="top" title="Data que a lista de preço é desativada"><i class="fas fa-info-circle"></i> Data de Fim:</label>
                    <input type="datetime-local" name="data_fim" step="1" value="{{ \Carbon\Carbon::parse($listaPreco->data_fim)->toDateTimeLocalString() }}" @class(['form-control', 'is-invalid' => $errors->has('data_fim')]) />
                    <x-admin.form-error property='data_fim'></x-admin.form-error>
                </div>
                <div class="form-group">
                    <label for="ajuste_mensal"  data-toggle="tooltip" data-placement="top" title="Ajuste no valor do produto, em porcentagem, para cada mês de diferença com esta data e a entrega do produto"><i class="fas fa-info-circle"></i> Ajuste Mensal (%):</label>
                    <input type="text" name="ajuste_mensal" value="{{ $listaPreco->ajuste_mensal }}" @class(['form-control mask-percentual', 'is-invalid' => $errors->has('ajuste_mensal')]) />
                    <x-admin.form-error property='ajuste_mensal'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>
</x-admin>
