<div class="carrinho-item">
    <p>Produto: {{ $pedidoItem->itemListaPreco->produto->nome }}</p>
    <p>Quantidade: {{ $pedidoItem->quantidade }}</p>
    <p>Preco: {{ $pedidoItem->itemListaPreco->calculaPreco() }}</p>
    <p>Endereco: {{ ($pedidoItem->usuarioEndereco) ? $pedidoItem->usuarioEndereco->nome : '' }}</p>
</div>
