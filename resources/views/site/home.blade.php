<x-site>
<p class="container">Home page xD</p>
@if(isset($flash_sale) && $flash_sale)
    @include('site.adicionais.flashsale')
@endif
</x-site>
