<x-site>
    <div class="auth forgot-password container">
        <div class="form">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <h2>Recuperar Senha:</h2>
                <span class="subtitle">Esqueceu sua senha? Informe um E-mail e enviaremos um link para definir uma nova senha para este E-mail</span>
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
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="botoes">
                    <button type="submit" class="btn">Recuperar Senha</button>
                    <a class="link" href="{{ route('login') }}">Ou clique aqui para fazer o login</a>
                </div>
            </form>
        </div>
    </div>
</x-site>
