<div class="carrinho-item border-bottom">
    <p>Produto: {{ $pedidoItem->itemListaPreco->produto->nome }}</p>
    <p>Quantidade: {{ $pedidoItem->quantidade }}</p>
    <p>Preco: {{ $pedidoItem->itemListaPreco->calculaPreco() }}</p>
    <p> <a href='{{ route('site.carrinho.editar', $pedidoItem->id) }}'>Editar</a> </p>
    <p> <a href='{{ route('site.carrinho.remover', $pedidoItem->id) }}'>Remover</a> </p>
</div>
