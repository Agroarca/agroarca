@php
    use App\Services\Site\CarrinhoService;
@endphp
@section('vue-app', true)

<x-site>
    <x-site.carrinho.carrinho :carrinho="$carrinho"></x-site.carrinho.carrinho>
    <x-site.recently-viewed  :class="['recently-viewed-section']"></x-site.recently-viewed>
</x-site>
