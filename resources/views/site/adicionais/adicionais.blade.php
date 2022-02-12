<x-site>
    <div class="carrinho">
        @foreach ($produtos as $produto)
            @include('site.adicionais.produto', ['produto' => $produto])
        @endforeach
    </div>
</x-site>
