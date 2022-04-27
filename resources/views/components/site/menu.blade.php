<div class="menu">
    <div></div>
    <a class="menu-item" href="{{ route('site.categoria', null) }}">Todas as Categorias</a>
    @if (!is_null(\App\Models\Estoque\Produto::first()))
        <a class="menu-item" href="{{ route('site.produto', \App\Models\Estoque\Produto::first()) }}">Produto Exemplo</a>
    @endif
    <div></div>
</div>
