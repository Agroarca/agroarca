<x-site>
<p class="container">Home page xD</p>

@php
    $items = [];
    foreach(range(1, 10) as $i){
        $items[] = [
            'subtitle' => 'Produtos de Qualidade',
            'title' => 'Sementes, fertilizantes e produtos para plantio.',
            'image' => asset('img/temp/example'.($i % 2 ? 1 : 2).'.png'),
            'action' => 'http://google.com',
            'actionTitle' => 'Ver Produtos'
        ];
    }
@endphp

@include('site.adicionais.banner-section', [
    'multiple' => true,
    'data' => $items
])

@include('site.adicionais.business-values')

@if(isset($flash_sale) && $flash_sale)
    @include('site.adicionais.flashsale')
@endif

</x-site>
