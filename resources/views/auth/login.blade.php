<x-site>
    <div class="login container">
        <div class="form">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2>Entrar:</h2>
                <div>
                    @if($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div>
                    <label for="email">E-mail:</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label for="password">Senha:</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                </div>
                <div>
                    <label for="remember_me" class="check-label">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Manter conectado?</span>
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
                <h2>Registrar:</h2>
                <div>
                    @if($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div>
                    <label for="nome">Nome:</label>
                    <input id="nome" type="text" name="nome" value="{{ old('nome') }}" required>
                </div>
                <div>
                    <label for="email">E-mail:</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label for="cpf_cnpj">Cpf ou Cnpj:</label>
                    <input id="cpf_cnpj" type="text" name="cpf_cnpj" value="{{ old('cpf_cnpj') }}" required>
                </div>
                <div>
                    <label for="celular">Celular:</label>
                    <input id="celular" type="text" name="celular" value="{{ old('celular') }}" required>
                </div>
                <div>
                    <label for="password">Senha:</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                </div>
                <div>
                    <label for="password_confirmation">Confirmar Senha:</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" value="old('email')" required>
                </div>

                <div class="botoes">
                    <button class="btn" type="submit">Registrar</button>
                </div>

            </form>
        </div>
    </div>
</x-site>
