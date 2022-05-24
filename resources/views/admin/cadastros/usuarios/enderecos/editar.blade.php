@php
use App\Models\Cadastros\Cidade;
@endphp

<x-admin>
    <x-slot name='header'>
        <h1>Novo Endereço</h1>
    </x-slot>
    <form action="{{ route('admin.cadastros.usuarios.enderecos.atualizar', [$usuario->id, $endereco->id]) }}" method="POST">
        <div class="card card-default">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="nome">Nome do endereço:</label>
                    <input type="text" name="nome" value="{{ $endereco->nome }}" placeholder="Ex.: Casa, Trabalho..."
                        @class(['form-control', 'is-invalid'=> $errors->has('nome')]) />
                    <x-admin.form-error property='nome'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="cep">CEP:</label>
                    <input type="text" name="cep" value="{{ $endereco->cep }}"
                        @class(['form-control', 'mask-cep' , 'is-invalid'=> $errors->has('cep')]) />
                    <x-admin.form-error property='cep'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="cidade_id">Cidade:</label>
                    <x-admin.select name='cidade_id' :values="[]"  data-s2-url="{{ route('api.cidades') }}" :selected="$endereco->cidade_id" placeholder="Selecione uma Cidade" :class="['form-control', 'is-invalid' => $errors->has('cidade_id')]"></x-admin.select>
                    <x-admin.form-error property='cidade_id'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="endereco">Endereço:</label>
                    <input type="text" name="endereco" value="{{ $endereco->endereco }}" placeholder="Ex.: Avenida Paulista, Rua Madalena..."
                        @class(['form-control' , 'is-invalid'=> $errors->has('endereco')]) />
                    <x-admin.form-error property='endereco'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="bairro">Bairro:</label>
                    <input type="text" name="bairro" value="{{ $endereco->bairro }}"
                        @class(['form-control' , 'is-invalid'=> $errors->has('bairro')]) />
                    <x-admin.form-error property='bairro'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="numero">Número:</label>
                    <input type="text" name="numero" value="{{ $endereco->numero }}"
                        @class(['form-control' , 'is-invalid'=> $errors->has('numero')]) />
                    <x-admin.form-error property='numero'></x-admin.form-error>
                </div>

                <div class="form-group">
                    <label for="complemento">Complemento:</label>
                    <input type="text" name="complemento" value="{{ $endereco->complemento }}" placeholder="Ex.: AP 126"
                        @class(['form-control' , 'is-invalid'=> $errors->has('complemento')]) />
                    <x-admin.form-error property='complemento'></x-admin.form-error>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </form>
</x-admin>
