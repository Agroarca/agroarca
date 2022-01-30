<x-site>
    <div class="carrinho">
        @foreach ($pedido->pedidoItens as $item)
            @include('site.carrinho.carrinho-item', ['pedido' => $pedido, 'pedidoItem' => $item])
        @endforeach
    </div>
</x-site>
