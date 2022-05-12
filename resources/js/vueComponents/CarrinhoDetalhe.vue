<script>
export default {
    props: ['carrinho']
}
</script>

<template>
    <div class="carrinho-detalhe">
        <div class="resumo">
            <h2>Resumo do Pedido:</h2>
        </div>
        <div class="subtotal">
            <h4>Total dos Produtos:</h4>
            <span>{{ carrinho.subtotal }}</span>
        </div>
        <div class="subtotal">
            <h4>Frete:</h4>
            <span>{{ carrinho.frete }}</span>
        </div>
        <div class="total">
            <h4>Total</h4>
            <span>{{ carrinho.total }}</span>
        </div>
    </div>
</template>

<style>
.carrinho-detalhe{
    background: #ffffff;
    border: 1px solid var(--cinza-claro);
    box-sizing: border-box;
    border-radius: 12px;
    padding: 1rem;
    font-family: "Poppins", Arial, Helvetica, sans-serif;
}

.carrinho-detalhe span,
.carrinho-detalhe h4{
    font-weight: 600;
}

.carrinho-detalhe .subtotal,
.carrinho-detalhe .total {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.carrinho-detalhe .subtotal span,
.carrinho-detalhe .subtotal h4 {
    font-size: 16px;
}

.carrinho-detalhe h4{
    color: var(--cinza-escuro);
}

.carrinho-detalhe span{
    color: var(--verde-claro);
}

.carrinho-detalhe .total{
    margin-top: 1rem;
    font-size: 24px;
}

.carrinho-detalhe .resumo h2{
    color: var(--preto);
    font-size: 18px;
    margin-bottom: 1rem;
}
</style>
