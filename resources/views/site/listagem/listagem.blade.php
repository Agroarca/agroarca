<x-site>
    @isset($categoria)
        <section class="container">
            <x-site.breadcrumb-categoria :categoria="$categoria"></x-site.breadcrumb-categoria>
        </section>
    @endisset

    <section class="container banner-info">
        <h2>Produtos para plantio...</h2>
        <p>Encontre aqui as melhores ofertas para o seu plantio.</p>
    </section>

    <section class="container listagem">
        {{-- @TODO: Fix vitrine produto fora de grid --}}
        <h2 class="section-title">Produtos</h2>
        <div class="produtos">
            @foreach ($produtos as $produto)
                @include('site.listagem.produto', $produto)
            @endforeach
        </div>
    </section>
</x-site>
