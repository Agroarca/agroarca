<x-site>
    <div class="container cart">
        <div class="row">
            <div class="col-md-8">
                @foreach ($pedido->pedidoItens as $item)
                    @include('site.carrinho.carrinho-item', ['pedido' => $pedido, 'pedidoItem' => $item])
                @endforeach
            </div>
            <div class="col-md-4">
                @include('site.carrinho.carrinho-detalhe', ['pedido' => $pedido])
            </div>
        </div>
    </div>
</x-site>
