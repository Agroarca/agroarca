@php
    use \App\Models\Cadastros\Estado;
@endphp

@section('InputMask', true)

<x-admin>
    <x-slot name='header'>
        <h1>Editar centro de distribuição {{ $centroDistribuicao->nome }}</h1>
    </x-slot>

    <form action="{{ route('admin.cadastros.usuarios.centrosDistribuicao.atualizar', [$usuario->id, $centroDistribuicao->id]) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ $centroDistribuicao->nome }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="representante">Representante:</label>
                    <input type="text" name="representante" value="{{ $centroDistribuicao->representante }}" @class(['form-control', 'is-invalid' => $errors->has('representante')]) />
                    <x-admin.form-error property='representante'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" name="cnpj" value="{{ $centroDistribuicao->cnpj }}" @class(['form-control mask-cnpj', 'is-invalid' => $errors->has('cnpj')]) />
                    <x-admin.form-error property='cnpj'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" value="{{ $centroDistribuicao->telefone }}" @class(['form-control mask-telefone', 'is-invalid' => $errors->has('telefone')]) />
                    <x-admin.form-error property='telefone'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="inscricao_estadual">Inscrição Estadual:</label>
                    <input type="text" name="inscricao_estadual" value="{{ $centroDistribuicao->inscricao_estadual }}" @class(['form-control', 'is-invalid' => $errors->has('inscricao_estadual')]) />
                    <x-admin.form-error property='inscricao_estadual'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="usuario_endereco_id">Endereço:</label>
                    <x-admin.select name='usuario_endereco_id' :values="$usuario->enderecos->pluck('nome', 'id')" :selected="$centroDistribuicao->usuario_endereco_id" placeholder="Selecione um Endereço" :class="['form-control', 'is-invalid' => $errors->has('usuario_endereco_id')]"></x-admin.select>
                    <x-admin.form-error property='usuario_endereco_id'></x-admin.form-error>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>
</x-admin>
