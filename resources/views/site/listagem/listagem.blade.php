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

        <div class="section-meta">
        <h2 class="section-title">Produtos</h2>
        <div class="section-filters">
                <div class="grid-selectable">
                    <i class="fa fa-th active" aria-hidden="true"></i>
                    <i class="fas fa-list"></i>
                </div>
                <div class="dropdown">

                <span>Ordenar por</span>
                    <button class="btn btn-secondary dropdown-toggle"type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                      Popularidade
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#">Popularidade</a></li>
                        <li><a class="dropdown-item" href="#">Menor preço</a></li>
                    </ul>
                  </div>
            </div>
        </div>

        {{-- @TODO: Fix vitrine produto fora de grid --}}
        {{-- PROBLEMA: width 90%, porem padding ou margin quebra o grid. --}}
        <div class="produtos">
            @foreach ($produtos as $produto)
                @include('site.listagem.produto', $produto)
            @endforeach
        </div>
    </section>
</x-site>
