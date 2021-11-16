@php
    $imagem = $produto->imagens()->first()
@endphp

<a class="produto" id="produto-{{ $produto->id }}" href="{{ route('site.produto', $produto->id) }}">
    <img class="imagem-produto" src="{{ asset("storage/produtos/$imagem->nome_arquivo") }}" alt={{ $imagem->descricao }}>
    <span class="titulo-produto">{{ $produto->nome }}</span>
    <span class="preco-produto">R$ 1254.29</span>
    <button class="btn-produto">Quero saber mais!</button>
</a>
