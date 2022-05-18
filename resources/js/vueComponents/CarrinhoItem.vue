<script>
import CarrinhoQuantidadeItem from './CarrinhoQuantidadeItem.vue'
import axios from "axios"
export default{
    inject: ['adicionarErro'],
    props: ['carrinhoitem'],
    components: {
        CarrinhoQuantidadeItem
    },
    methods: {
        alterarquantidade(quantidade){
            let _this = this;

            axios.post(this.carrinhoitem.link_alterar_quantidade,{
                quantidade: quantidade
            }).then(function (response){

                if(response.data.erro){
                    _this.adicionarErro(response.data.erro)
                    return
                }

                if(response.data.carrinho){
                    _this.$emit('alterarCarrinho', response.data.carrinho)
                }
            }).catch(function(error){
                _this.adicionarErro("ocorreu um erro ao alterar a quantidade, tente novamente mais tarde");
                setTimeout(() => {
                    window.location.reload();
                }, 5000);
            })
        },
        removerItem(event){
            event.preventDefault();
            let _this = this;

            axios.get(this.carrinhoitem.link_remover)
            .then(function (response){

                if(response.data.erro){
                    _this.adicionarErro(response.data.erro)
                    return
                }

                if(response.data.carrinho){
                    _this.$emit('alterarCarrinho', response.data.carrinho)
                }

            }).catch(function(error){
                _this.adicionarErro("ocorreu um erro ao remover o item, tente novamente mais tarde");
                setTimeout(() => {
                    window.location.reload();
                }, 5000);
            })
        }
    }
}
</script>

<template>
    <div class="carrinho-item" :data-id="carrinhoitem.id">
        <div class="item-detalhe row">
            <div class="imagem col-6 col-md-4">
                <img :src="carrinhoitem.imagem.src" :alt="carrinhoitem.imagem.descricao">
            </div>
            <div class="informacoes col-6 col-md-4">
                <h4>{{ carrinhoitem.nomeProduto }}</h4>
                <span class="preco">{{ carrinhoitem.preco }}</span>
                <span class="preco-unidade">
                    {{ carrinhoitem.preco_unidade }} / {{ carrinhoitem.unidade }}
                </span>
            </div>
            <div class="detalhes d-flex flex-row align-items-end justify-content-center justify-content-md-end col-12 col-md-4">
                <CarrinhoQuantidadeItem class='quantidade-item component-carrinho-quantidade-item' :value='carrinhoitem.quantidade' name='quantidade' @alterarquantidade="alterarquantidade" />
                <a href='#' @click="removerItem">
                    <button class="remover"><i class="fa fa-trash"></i></button>
                </a>
            </div>
        </div>

            <div class="adicionais" v-for="(itensAdicionais,id) in carrinhoitem.pedidoItensAdicionais" :key="id">
                <b>{{ itensAdicionais.tipo }}</b>
                <ul class="informacoes">
                    <li class="item-adicional" v-for="itemAdicional in itensAdicionais.itens" :key="itemAdicional.nomeProduto">
                        {{ itemAdicional.nomeProduto }}
                    </li>
                </ul>
            </div>
    </div>
</template>

<style>
.carrinho .carrinho-item {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    background: #ffffff;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.06);
    border-radius: 12px;
    padding: 1rem;
    margin: 2rem 0;
}

.carrinho .carrinho-item:first-child{
    margin-top: 0
}

.carrinho .carrinho-item:last-child{
    margin-bottom: 0
}

.carrinho .carrinho-item .item-detalhe{
    display: flex;
    width: 100%;
}

.carrinho .carrinho-item img {
    height: auto;
    width: 100%;
    border-radius: 14px;
}

.carrinho .carrinho-item .informacoes {
    display: flex;
    flex-direction: column;
}

.carrinho .carrinho-item .preco {
    font-family: "Poppins", Arial, Helvetica, sans-serif;
    margin-top: 0.5rem;
    color: var(--verde-claro);
    font-size: 24px;
    font-weight: 600;
}

.carrinho .carrinho-item .preco-unidade {
    font-family: "Poppins", Arial, Helvetica, sans-serif;
    color: var(--cinza-escuro);
    font-size: 16px;
    font-weight: 500;
}

.carrinho .carrinho-item .detalhes {
    flex: auto;
    gap: 10px;
    padding-top: 1rem;
}
/*
.carrinho .carrinho-item .detalhes {
    display: flex;
    align-items: flex-end;
    justify-content: flex-end;
    flex: auto;
}*/

/* .cart .cart-data-item .cart-item-details .seed-tsi {
    width: 56px;
    height: 56px;
    padding: 4px;
    border-radius: 12px;
    border: unset;
    background: url("/img/semente-maca.svg") top center no-repeat;
    background-color: var(--verde-claro);
} */

.carrinho .carrinho-item .quantidade-item {
    height: 56px;
    display: flex;
}

.carrinho .carrinho-item .remover {
    width: 56px;
    height: 56px;
    color: var(--borda);
    border: 1px solid var(--borda);
    background: var(--branco);
    font-size: 24px;
    border-radius: 12px;
}

/* ADICIONAIS */

.carrinho .carrinho-item .adicionais .informacoes {
    list-style: none;
    padding: unset;
}

.carrinho .carrinho-item .adicionais b {
    font-size: 16px;
    color: var(--subtitulo);
    font-weight: bold;
}

.carrinho .carrinho-item .adicionais {
    margin-top: 1rem;
}

.carrinho .carrinho-item .item-adicional {
    color: var(--subtitulo);
    font-weight: 100;
    font-size: 14px;
}
</style>
