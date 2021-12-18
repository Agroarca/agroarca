<x-site>
    <div class="auth reset-password container">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email">E-mail:</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label for="password">Senha:</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>

            <div>
                <label for="password_confirmation">Confirmar Senha:</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <div class="botoes">
                <button class="btn" type="submit">Atualizar Senha</button>
            </div>
        </form>
    </div>
</x-site>
