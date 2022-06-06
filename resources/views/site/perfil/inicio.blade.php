<x-site>
    <section class="perfil auth container d-flex flex-column">
        <form class="row" method="POST" action="{{ route('site.perfil.atualizar') }}">
            @csrf
            <div class="col-12">
                <h2>Minha Conta</h2>
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
                <input class="form-control" id="nome" type="text" name="nome" value="{{ $usuario->nome }}">
            </div>
            <div class="col-12 col-lg-6">
                <label for="email-register">E-mail:</label>
                <input class="form-control" id="email-register" type="email" name="email" value="{{  $usuario->email }}">
            </div>
            <div class="col-12 col-lg-6">
                <label for="cpf_cnpj">Cpf ou Cnpj:</label>
                <input class="form-control" id="cpf_cnpj" type="text" name="cpf_cnpj" value="{{ $usuario->cpf ?? $usuario->cnpj }}">
            </div>
            <div class="col-12 col-lg-6">
                <label for="celular">Celular:</label>
                <input class="form-control" id="celular" type="text" name="celular" value="{{ $usuario->celular }}">
            </div>
            <div class="col-12 col-lg-6">
                <label for="password-register">Alterar Senha:</label>
                <input class="form-control" id="password-register" type="password" name="password" autocomplete="new-password">
            </div>
            <div class="col-12 col-lg-6">
                <label for="password_confirmation">Confirmar Senha:</label>
                <input class="form-control" id="password_confirmation" type="password" name="password_confirmation">
            </div>
            <div class="col-12">
                <button class="btn" type="submit">Atualizar Dados</button>
            </div>
        </form>
        <div class="row">
            <div class="col-12">
                <h3>Endereços</h3>
            </div>
            @foreach ($usuario->enderecos as $endereco)
                <div class="col-12">
                    <div class="endereco d-flex flex-row flex-nowrap justify-content-between">
                        <div>
                            <h3>{{ $endereco->nome }}</h3>
                            <span>{{ $endereco->endereco }}, {{ $endereco->numero }}, {{ $endereco->bairro }}</span>
                            <span>{{ $endereco->cep }}, {{ $endereco->cidade->nome }} - {{ $endereco->cidade->estado->uf }}</span>
                            @if($endereco->complemento)
                                <span>{{ $endereco->complemento }}</span>
                            @endif
                        </div>
                        <div class="d-flex align-self-center flex-row align-items-end justify-content-center botoes">
                            <div class="d-flex justify-content-end align-self-center">
                                <a href="{{ route('site.perfil.enderecos.selecionarPadrao', $endereco->id) }}" @class(["btn icone alt", 'ativo' => $endereco->padrao])>
                                    <i class="fa-solid fa-truck-moving"></i>
                                </a>
                            </div>
                            <div class="d-flex justify-content-end align-self-center">
                                <a href="{{ route('site.perfil.enderecos.excluir', $endereco->id) }}" class="btn icone alt">
                                    <i class="fas fa-trash-can"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-12">
                <a href="{{ route('site.perfil.enderecos.adicionar') }}" class="btn" type="submit">Adicionar Endereço</a>
            </div>
        </div>
    </section>
</x-site>
