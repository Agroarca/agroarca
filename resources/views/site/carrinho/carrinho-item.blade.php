<div class="carrinho-item border-bottom">
    <p>Produto: {{ $pedidoItem->itemListaPreco->produto->nome }}</p>
    <p>Quantidade: {{ $pedidoItem->quantidade }}</p>
    <p>Preco: {{ $pedidoItem->itemListaPreco->calculaPreco() }}</p>
    <p>Endereco: {{ ($pedidoItem->usuarioEndereco) ? $pedidoItem->usuarioEndereco->nome : '' }}</p>
    <p> <a href='{{ route('site.carrinho.remover', $pedidoItem->id) }}'>Remover</a> </p>
</div>
