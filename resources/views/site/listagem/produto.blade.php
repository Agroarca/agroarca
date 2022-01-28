@php
    use App\Helpers\Formatter;
    if(count($produto->imagens) > 0){
        $imagem = $produto->imagens[0];
    }else{
        throw new Exception($produto->id);

    }
@endphp

<a class="produto" id="produto-{{ $produto->id }}" href="{{ route('site.produto', $produto->id) }}">
    <img class="imagem-produto" src="{{ asset("storage/produtos/$imagem->nome_arquivo") }}" alt={{ $imagem->descricao }}>
    <span class="titulo-produto">{{ $produto->nome }}</span>
    <span class="preco-produto">{{ Formatter::preco($produto->itensListaPreco->first()->calculaPreco()) }} Kg</span>
    <button class="btn-produto">Quero saber mais!</button>
</a>
