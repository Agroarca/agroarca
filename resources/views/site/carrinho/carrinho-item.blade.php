<div class="cart-item">
    <div class="cart-data-item">
        <div class="product-image"></div>
        <div class="cart-product-meta">
            <h4>{{ $pedidoItem->itemListaPreco->produto->nome }}</h4>
            <span class="cart-product-price">R$ {{ $pedidoItem->itemListaPreco->calculaPreco() }}</span>

            <div class="treatments">
                <b>Tratamentos:</b>
                <ul class="treatments-data">
                    <li class="treatment-item">
                        Cruiser 350 1ml/Kg + Pó Secante 2gr/Kg
                    </li>
                    <li class="treatment-item">
                        Cruiser 350 1ml/Kg + Pó Malandro 2gr/Kg
                    </li>
                    <li class="treatment-item">
                        Cruiser 350 1ml/Kg + Pó Muito malandro 2gr/Kg
                    </li>
                </ul>
            </div>
        </div>
        <div class="cart-item-details">

            <button class="seed-tsi"></button>
            <div class="amount-details">
                <button class="minus"><i class="fa fa-minus"></i></button>
                <input type="text" class="qty" value="{{ $pedidoItem->quantidade }}">
                <button class="plus"><i class="fa fa-plus"></i></button>
            </div>
            <button class="remove"><i class="fa fa-trash"></i></button>
            <button class="favorite"><i class="fa fa-heart"></i></button>
        </div>
    </div>

    {{-- <p>Quantidade: {{ $pedidoItem->quantidade }}</p>
    <p> <a href='{{ route('site.carrinho.editar', $pedidoItem->id) }}'>Editar</a> </p>
    <p> <a href='{{ route('site.carrinho.remover', $pedidoItem->id) }}'>Remover</a> </p> --}}
</div>
