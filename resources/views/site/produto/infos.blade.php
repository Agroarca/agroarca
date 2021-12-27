
@if ($produto->codigo)
    <span class="cod">COD {{ $produto->codigo }}</span>
@endif
<h1 class="nome">{{ $produto->nome }}</h1>
<p class="descricao">{{ $produto->descricao }}</p>
