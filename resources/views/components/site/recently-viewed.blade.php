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
