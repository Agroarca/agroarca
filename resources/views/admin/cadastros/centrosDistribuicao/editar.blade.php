@php
use App\Models\Cadastros\Cidade;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Editar Centro de Distribuição {{ $centroDistribuicao->nome }}</h1>
    </x-slot>

    <form action="{{ route('admin.cadastros.centrosDistribuicao.atualizar', $centroDistribuicao->id) }}" method="POST">
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
                    <label for="cep">CEP:</label>
                    <input type="text" name="cep" value="{{ $centroDistribuicao->cep }}" @class(['form-control', 'mask-cep' , 'is-invalid'=> $errors->has('cep')]) />
                    <x-admin.form-error property='cep'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="endereco">Endereço:</label>
                    <input type="text" name="endereco" value="{{ $centroDistribuicao->endereco }}" placeholder=".: Avenida Paulista, Rua Madalena..." @class(['form-control' , 'is-invalid'=> $errors->has('endereco')]) />
                    <x-admin.form-error property='endereco'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="numero">Número:</label>
                    <input type="text" name="numero" value="{{ $centroDistribuicao->numero }}" @class(['form-control' , 'is-invalid'=> $errors->has('numero')]) />
                    <x-admin.form-error property='numero'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="bairro">Bairro:</label>
                    <input type="text" name="bairro" value="{{ $centroDistribuicao->bairro }}" @class(['form-control' , 'is-invalid'=> $errors->has('bairro')]) />
                    <x-admin.form-error property='bairro'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="cidade_id">Cidade:</label>
                    <x-admin.select name='cidade_id' :values="[]" data-s2-url="{{ route('api.cidades') }}" :selected="$centroDistribuicao->cidade_id" placeholder="Selecione uma Cidade" :class="['form-control', 'is-invalid' => $errors->has('cidade_id')]"></x-admin.select>
                    <x-admin.form-error property='cidade_id'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="complemento">Complemento:</label>
                    <input type="text" name="complemento" value="{{ $centroDistribuicao->complemento }}" placeholder=".: AP 126" @class(['form-control' , 'is-invalid'=> $errors->has('complemento')]) />
                    <x-admin.form-error property='complemento'></x-admin.form-error>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </form>
</x-admin>
