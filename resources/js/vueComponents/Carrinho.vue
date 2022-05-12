<script>
import CarrinhoItem from './CarrinhoItem.vue'
import CarrinhoDetalhe from './CarrinhoDetalhe.vue'

export default{
    components: {
        CarrinhoItem,
        CarrinhoDetalhe
    },
    data(){
        return{
            carrinho: window.carrinhoDados
        }
    },
    methods: {
        alterarCarrinho(carrinho){
            this.carrinho = carrinho
        }
    }
}
</script>

<template>
    <section class="container cart carrinho">
        <div class="row">
            <div class="col-xl-8 col-12">
                <CarrinhoItem v-for='carrinhoitem in carrinho.pedidoItens' :carrinhoitem="carrinhoitem" :key="carrinhoitem.id" @alterarCarrinho="alterarCarrinho"/>
            </div>
            <div class="col-xl-4 col-12 pt-4 pt-xl-0">
                <CarrinhoDetalhe :carrinho="carrinho" />
            </div>
        </div>
        </section>
</template>
