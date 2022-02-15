<section class="flash-sale">
    <div class="container">
        <div class="grid-container">

            <div class="flash-sale-item flash-sale-info">
                <h2>OFERTA RELÂMPAGO</h2>
                <p>Confira nossa oferta relâmpago e não perca a oportunidade de pagar barato!!!</p>
                <span class="countdown">05  :  42  :  19  :  54</span>
            </div>
            <div class="flash-sale-item" >
                <div class="flash-sale-carousel  owl-carousel owl-theme" id="flash-sale-carousel">
                    @foreach(range(1, 10) as $i)  {{-- Loop apenas para testes. --}}
                    <div class="product-showcase-item">
                        <div class="showcase-item-image"
                        ></div>

                        <div class="product-details">
                            <h4 class="showcase-title">Titulo do produto</h4>
                            <span class="preco-produto">R$ 512,00</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="meta-grid">
                    <div class="section-nav">
                        <button id="flashsale-nav-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                        <button id="flashsale-nav-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                    </div>
                    <a href="#" class="see-more">Ver mais</a>
                </div>
            </div>
        </div>
    </div>
</section>
