<x-site>
    <section div class="auth login container">
        <div class="form">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2 class="mb-5">Entrar:</h2>
                <div class="row">
                    @if($errors->any() && session()->get('authType') === 'login')
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="row">
                    <label for="email">E-mail:</label>
                    <input class="form-control" id="email" type="email" name="email" value="{{ session()->get('authType') === 'login' ? old('email') : ''  }}" required>
                </div>
                <div class="row">
                    <label for="password">Senha:</label>
                    <input class="form-control" id="password" type="password" name="password" required autocomplete="current-password">
                </div>
                <div class="form-check">
                    <input class="form-check-input" class="form-control" id="remember_me" type="checkbox" name="remember">
                    <label  class="form-check-label" for="remember_me" for="remember_me" class="check-label">
                        Manter conectado?
                    </label>
                </div>

                <div class="botoes">
                    <button type="submit" class="btn">Entrar</button>

                    @if (Route::has('password.request'))
                        <a class="link" href="{{ route('password.request') }}">Esqueceu sua Senha?</a>
                    @endif
                </div>
            </form>
        </div>
        <div class="form register">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h2 class="mb-5">Registrar:</h2>
                <div>
                    @if($errors->any() && session()->get('authType') === 'register')
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="row">
                    <label for="nome">Nome:</label>
                    <input class="form-control" id="nome" type="text" name="nome" value="{{ old('nome') }}" required>
                </div>
                <div class="row">
                    <label for="email-register">E-mail:</label>
                    <input class="form-control" id="email-register" type="email" name="email" value="{{  session()->get('authType') === 'register' ? old('email') : '' }}" required>
                </div>
                <div class="row">
                    <label for="cpf_cnpj">Cpf ou Cnpj:</label>
                    <input class="form-control" id="cpf_cnpj" type="text" name="cpf_cnpj" value="{{ old('cpf_cnpj') }}" required>
                </div>
                <div class="row">
                    <label for="celular">Celular:</label>
                    <input class="form-control" id="celular" type="text" name="celular" value="{{ old('celular') }}" required>
                </div>
                <div class="row">
                    <label for="password-register">Senha:</label>
                    <input class="form-control" id="password-register" type="password" name="password" required autocomplete="new-password">
                </div>
                <div class="row">
                    <label for="password_confirmation">Confirmar Senha:</label>
                    <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <div class="botoes">
                    <button class="btn" type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </section>
</x-site>
