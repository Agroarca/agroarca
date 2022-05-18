@php
    use App\Helpers\Formatter;
    $imagem = $produto->imagens[0];
@endphp

<a class="produto" id="produto-{{ $produto->id }}" href="{{ route('site.produto', $produto->id) }}">
    <img class="imagem" src="{{ asset("storage/produtos/$imagem->nome_arquivo") }}" alt={{ $imagem->descricao }}>
    <span class="titulo">{{ $produto->nome }}</span>
    <span class="preco">{{ Formatter::preco($produto->itensListaPreco->first()->preco_item) }} Kg</span>
    <button class="btn">Quero saber mais!</button>
</a>
