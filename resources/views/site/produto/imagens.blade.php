@php
    $imagem = $imagens[0];
@endphp
<div class="imagem single">
    <img class="imagem-produto" src="{{ asset("storage/produtos/$imagem->nome_arquivo") }}" alt={{ $imagem->descricao }} width="800" height="600">
</div>
