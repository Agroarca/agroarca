@php
    use \App\Helpers\Formatter;
@endphp

@if ($produto->codigo)
    <span class="cod">COD {{ $produto->codigo }}</span>
@endif
<h1 class="nome">{{ $produto->nome }}</h1>
<p class="descricao">{{ $produto->descricao }}</p>
<span class="preco">{{ Formatter::preco($precoProduto->preco_quilo) }} Kg.</span>
<span class="preco">{{ Formatter::preco($precoProduto->preco_total) }} Kg.</span>
<div class="cep">
    <form method="POST" action="{{ route('site.produto.cep', $produto->id) }}">
        @csrf
        <input type="text" class="form-cep" id="cep" name="cep" value="{{ request()->cookie('cep') }}">
        <input type="submit">
    </form>
</div>
<div class="adicionar">
    <form method="POST" action="{{ route('site.produto.adicionar', $produto->id) }}">
        @csrf
        <input type="submit" value="Adicionar">
    </form>
</div>
