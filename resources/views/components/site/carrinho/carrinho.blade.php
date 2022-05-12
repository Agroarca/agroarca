@push('pre-js')
    <script>
        window.carrinhoDados = JSON.parse({{ Illuminate\Support\Js::from($carrinho) }})
    </script>
@endpush

{{-- inicia o componente carrinho do vue e joga o carrinho pra dentro do slot cuidar --}}
<carrinho>
    {{-- <template #default="{carrinho,alterar_carrinho}">
        <section class="container cart">
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="cart-header">
                        <div class="content-selectable">
                            <span>Selecionar Tudo</span>
                        </div>
                        <div class="meta-content">
                            <span>Atualizar Carrinho</span>
                            <span>Remover</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    php
                        $hasCoupon = true;
                    endphp
                    <div class="cart-header-coupon { hasCoupon ? 'active' : '' } ">
                        <i class="fa-solid fa-money-bill"  aria-hidden="true"></i>

                        @if($hasCoupon)
                        Você tem 1 código promocional
                        @else
                        Possui um cupom de desconto? <b>Adicione aqui.</b>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <carrinho-item v-for='carrinhoitem in carrinho.pedidoItens' :carrinhoitem="carrinhoitem"></carrinho-item>
                </div>
                <div class="col-md-4">
                    {{-- @include('site.carrinho.carrinho-detalhe', ['pedido' => $pedido])
                </div>
            </div>
        </section>
    </template>--}}
</carrinho>
