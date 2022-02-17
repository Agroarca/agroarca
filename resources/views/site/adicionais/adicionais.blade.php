<x-site>
    <div class="carrinho">
        <form method="POST" action="{{ route('site.addAdicionais', $pedidoItem->id) }}">
            @csrf
            <div class="form-group">
                <label for="quantidade"><i class="fas fa-info-circle"></i> Quantidade (Kg):</label>
                <input type="text" name="quantidade" value="{{ $pedidoItem->quantidade }}" @class(['form-control mask-quilo', 'is-invalid' => $errors->has('quantidade')]) />
                <x-admin.form-error property='quantidade'></x-admin.form-error>
            </div>
            @if($pedidoItem->quantidade > 0)
                @foreach ($produtos as $produto)
                    @include('site.adicionais.produto', ['produto' => $produto])
                @endforeach
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </form>
    </div>
</x-site>
