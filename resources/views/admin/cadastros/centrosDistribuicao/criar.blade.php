@php
use App\Models\Cadastros\Cidade;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Novo Centro de Distribuição</h1>
    </x-slot>
    <form action="{{ route('admin.cadastros.centrosDistribuicao.salvar') }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" @class(['form-control', 'is-invalid' => $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="representante">Representante:</label>
                    <input type="text" name="representante" value="{{ old('representante') }}" @class(['form-control', 'is-invalid' => $errors->has('representante')]) />
                    <x-admin.form-error property='representante'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" name="cnpj" value="{{ old('cnpj') }}" @class(['form-control mask-cnpj', 'is-invalid' => $errors->has('cnpj')]) />
                    <x-admin.form-error property='cnpj'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" value="{{ old('telefone') }}" @class(['form-control mask-telefone', 'is-invalid' => $errors->has('telefone')]) />
                    <x-admin.form-error property='telefone'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="inscricao_estadual">Inscrição Estadual:</label>
                    <input type="text" name="inscricao_estadual" value="{{ old('inscricao_estadual') }}" @class(['form-control', 'is-invalid' => $errors->has('inscricao_estadual')]) />
                    <x-admin.form-error property='inscricao_estadual'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="cep">CEP:</label>
                    <input type="text" name="cep" value="{{ old('cep') }}" @class(['form-control', 'mask-cep' , 'is-invalid'=> $errors->has('cep')]) />
                    <x-admin.form-error property='cep'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="endereco">Endereço:</label>
                    <input type="text" name="endereco" value="{{ old('endereco') }}" placeholder="Ex.: Avenida Paulista, Rua Madalena..." @class(['form-control' , 'is-invalid'=> $errors->has('endereco')]) />
                    <x-admin.form-error property='endereco'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="numero">Número:</label>
                    <input type="text" name="numero" value="{{ old('numero') }}" @class(['form-control' , 'is-invalid'=> $errors->has('numero')]) />
                    <x-admin.form-error property='numero'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="bairro">Bairro:</label>
                    <input type="text" name="bairro" value="{{ old('bairro') }}" @class(['form-control' , 'is-invalid'=> $errors->has('bairro')]) />
                    <x-admin.form-error property='bairro'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="cidade_id">Cidade:</label>
                    <x-admin.select name='cidade_id' :values="Cidade::selectTodos()" :selected="old('cidade_id')" placeholder="Selecione uma Cidade" :class="['form-control', 'is-invalid' => $errors->has('cidade_id')]"></x-admin.select>
                    <x-admin.form-error property='cidade_id'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="complemento">Complemento:</label>
                    <input type="text" name="complemento" value="{{ old('complemento') }}" placeholder="Ex.: AP 126" @class(['form-control' , 'is-invalid'=> $errors->has('complemento')]) />
                    <x-admin.form-error property='complemento'></x-admin.form-error>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </div>
    </form>
</x-admin>
