<x-site>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h2>Entrar</h2>
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
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">Senha</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
        </div>
        <div>
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Manter conectado</span>
            </label>
        </div>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Esqueceu sua Senha?</a>
        @endif

        <button type="submit">Entrar</button>
    </form>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h2>Registrar</h2>
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
            <label for="nome">Nome</label>
            <input id="nome" type="text" name="nome" value="{{ old('nome') }}" required>
        </div>
        <div>
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">Senha</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
        </div>
        <div>
            <label for="password_confirmation">Confirmar Senha</label>
            <input id="password_confirmation" type="password" name="password_confirmation" value="old('email')" required>
        </div>

        <button type="submit">Registrar</button>
    </form>
</x-site>
