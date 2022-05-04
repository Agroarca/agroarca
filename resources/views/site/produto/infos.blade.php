@php
    use \App\Helpers\Formatter;
@endphp

@if ($produto->codigo)
    <span class="cod">COD {{ $produto->codigo }}</span>
@endif
<h1 class="nome">{{ $produto->nome }}</h1>
<p class="descricao">{{ $produto->descricao }}</p>
<span class="preco-produto">{{ Formatter::preco($precoProduto->preco_quilo) }} Kg.</span>
<div class="frete-produto">
    Frete:
    <span>{{ Formatter::preco($precoProduto->frete_quilo) }} Kg.</span>
</div>
<hr />

<div class="cep">
    <span>Digite seu CEP para calcular o frete</span>
    <form method="POST" action="{{ route('site.produto.cep', $produto->id) }}">
        @csrf
        <input type="text" class="form-cep mask-cep" id="cep" name="cep" value="{{ session('cep') }}" onchange="verificarCep(this)">
    </form>
</div>

<div class="adicionar">
    <form method="POST" class="d-flex flex-column flex-lg-row justify-content-between" action="{{ route('site.produto.adicionar', $produto->id) }}">
        @csrf
        <x-site.carrinho.quantidade-item class="quantidade-detalhe" name='quantidade'></x-site.carrinho.quantidade-item>
        <input class="botao adicionar d-block d-lg-flex mx-auto mx-lg-0 mt-3 mt-lg-0" type="submit" value="Comprar">
    </form>
</div>
