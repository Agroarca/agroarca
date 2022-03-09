@php
    $imagem = $pedidoItem->itemListaPreco->produto->imagens[0];
@endphp

<div class="cart-item">
    <div class="cart-data-item">
        <div class="product-image">
            <img src="{{ asset("storage/produtos/$imagem->nome_arquivo") }}" alt={{ $imagem->descricao }}>
        </div>
        <div class="cart-product-meta">
            <h4>{{ $pedidoItem->itemListaPreco->produto->nome }}</h4>
            <span class="cart-product-price">R$ {{ $pedidoItem->itemListaPreco->calculaPreco() }}</span>
            <span class="cart-product-minor-price">R$ {{ $pedidoItem->itemListaPreco->preco_quilo }} / kg</span>

            @if($pedidoItem->pedidoItensAdicionais()->count() > 0)
            <div class="treatments">
                <b>TSIs:</b>
                <ul class="treatments-data">
                    @foreach ($pedidoItem->pedidoItensAdicionais as $adicional)
                        <li class="treatment-item">
                            {{ $adicional->itemListaPreco->produto->nome }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        <div class="cart-item-details">
            <button class="seed-tsi">
                {{--
                    @TODO: Abrir modal para selecionar TSIs.
                    layout conforme figma: https://www.figma.com/file/OIUAXTc9iZXZLAwndWiLFs/AgroArca---Pilati---Mobile-KIT-UI---Entrega?node-id=0%3A1
                    --}}
                </button>
                <div class="amount-details">
                    <button class="minus"><i class="fa fa-minus"></i></button>
                <input type="text" class="qty" value="{{ $pedidoItem->quantidade }}">
                <button class="plus"><i class="fa fa-plus"></i></button>
            </div>
            <a href='{{ route('site.carrinho.remover', $pedidoItem->id) }}'>
                <button class="remove"><i class="fa fa-trash"></i></button>
            </a>
        </div>
    </div>

    {{-- <p>Quantidade: {{ $pedidoItem->quantidade }}</p>
    <p> <a href='{{ route('site.carrinho.editar', $pedidoItem->id) }}'>Editar</a> </p>
    <p> <a href='{{ route('site.carrinho.remover', $pedidoItem->id) }}'>Remover</a> </p> --}}
</div>
