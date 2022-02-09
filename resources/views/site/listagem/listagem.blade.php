<x-site>
    <section class="content listagem">
        <div class="container">
            @isset($categoria)
                <x-site.breadcrumb-categoria :categoria="$categoria"></x-site.breadcrumb-categoria>
            @endisset

            <div class="container banner-info">
                <h2>Produtos para plantio...</h2>
                <p>Encontre aqui as melhores ofertas para o seu plantio.</p>
            </div>

            {{-- @TODO:: Melhorar section title.  --}}
            {{-- @TODO2:: Quebrar em sections. --}}

            <h2>Produtos</h2>
            <div class="produtos">
                @foreach ($produtos as $produto)
                    @include('site.listagem.produto', $produto)
                @endforeach
            </div>
        </div>
    </section>
</x-site>
