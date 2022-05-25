<x-site>
    <section class="criar-endereco auth container d-flex flex-column">
        <form class="row" method="POST" action="{{ route('site.perfil.enderecos.salvar') }}">
            @csrf
            <div class="col-12">
                <h2>Criar Endereço</h2>
            </div>
            <div class="col-12">
                @if($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-12 col-lg-6">
                <label for="nome">Nome:</label>
                <input class="form-control" id="nome" type="text" name="nome" value="{{ old('nome') }}">
            </div>
            <div class="col-12 col-lg-6">
                <label for="cep">CEP:</label>
                <input class="form-control" id="cep" type="text" name="cep" value="{{  old('cep') }}">
            </div>
            <div class="col-12 col-lg-6">
                <label for="endereco">Endereço:</label>
                <input class="form-control" id="endereco" type="text" name="endereco" value="{{ old('endereco') }}">
            </div>
            <div class="col-12 col-lg-6">
                <label for="numero">Número:</label>
                <input class="form-control" id="numero" type="text" name="numero" value="{{ old('numero') }}">
            </div>
            <div class="col-12 col-lg-6">
                <label for="bairro">Bairro:</label>
                <input class="form-control" id="bairro" type="text" name="bairro" value="{{ old('bairro') }}">
            </div>
            <div class="col-12 col-lg-6">
                <label for="complemento">Complemento:</label>
                <input class="form-control" id="complemento" type="text" name="complemento" value="{{ old('complemento') }}">
            </div>
            <div class="col-12 col-lg-6">
                <label for="cidade">Cidade:</label>
                <x-admin.select name='cidade_id' :values="[]" data-s2-url="{{ route('api.cidades') }}" :selected="old('cidade_id')" placeholder="Selecione uma Cidade" :class="['form-control', 'is-invalid' => $errors->has('cidade_id')]"></x-admin.select>
            </div>
            <div class="col-12">
                <button class="btn" type="submit">Salvar Endereço</button>
            </div>
        </form>
    </section>
</x-site>
