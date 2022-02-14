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

    <section class="container">
        <div class="section-meta">
            <h2 class="section-title">Produtos Visualizados Recentemente</h2>
            <div class="section-nav">
                <i class="fa fa-chevron-left" aria-hidden="true" id="recently-viewed-nav-left"></i>
                <i class="fa fa-chevron-right" aria-hidden="true" id="recently-viewed-nav-right"></i>
            </div>
        </div>
        <div class="recently-viewed listagem owl-carousel owl-theme" id="recently-viewed-carousel">

            {{-- @TODO: Componentizar para utilizar com include. --}}
            @foreach(range(1, 10) as $i)  {{-- Loop apenas para testes. --}}
            <div class="product-showcase-item">
                <div class="showcase-item-image"
                {{-- @TODO: Quando retornar do backend, utilizar como background-image. style="background-image()" --}}
                ></div>

                <div class="product-details">
                    <h4 class="showcase-title">Titulo do produto</h4>
                    <span class="preco-produto">R$ 512,00</span>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    @include('site.adicionais.newsletter')
</x-site>
