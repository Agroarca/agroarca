<x-site>
    <div class="auth confirm-password container">
        <div class="form">
            <form method="POST" action="{{ route('password.confirm')}}">
                @csrf
                <h2>Confirmar Senha:</h2>
                <span class="subtitle">Essa é uma área restrita do site. Confirme sua senha para continuar</span>
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
                    <label for="password">Senha:</label>
                    <input id="password" type="password" name="password" required autofocus autocomplete="current-password">
                </div>
                <div class="botoes">
                    <button type="submit" class="btn">Confirmar Senha</button>
                </div>
            </form>
        </div>
    </div>
</x-site>
