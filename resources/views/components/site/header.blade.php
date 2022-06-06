@php
    use App\Services\Site\CarrinhoService;
@endphp

{{-- @include('site.adicionais.modals.delivery-information') --}}

<div class="py-2 header-contact">
    <div class="container contact-container d-flex flex-nowrap">

        <span class="phone"><i class="fas fa-phone-alt"></i>+55 54 9902-0345</span>
        <span class="mail"><i class="fas fa-envelope"></i>contato@agroarca.com.br</span>
        <a class="painel" href="{{ route('admin.inicio') }}">
            <i class="fa-solid fa-chart-line"></i>
            <span class="d-none d-sm-inline">Acessar o Painel</span>
        </a>

        {{-- @TODO: Precisa implementar endpoint no backend, e pegar valor da section aqui --}}
        {{-- Tambem verificar se o usuario esta autenticado e se tem endereco cadastrado antes de mostrar --}}
        {{-- <span class="delivery" id="delivery-content"><i class="fa fa-truck"></i><b>Onde deseja a entrega?</b> <small>(temporario)</small></span> --}}


    </div>
</div>
<header class="py-0 py-md-3 mb-4 navbar navbar-expand-md d-block">

    <div class="container-fluid main flex-wrap flex-md-nowrap">
        <div class="header-item text-decoration-none logo-container order-1">
            <a href="{{ url('/') }}">
                <img class="logo" src="{{ asset('img/logo.png') }}">
            </a>
        </div>
        <div class="header-item search-container input-group order-5 order-md-2">
            <input placeholder="Pequisar produtos..." type="text" class="search form-control">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>

        <div class="header-item arca-container order-3">
            <a href="{{ route('site.carrinho') }}">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-placeholder" id="cart-amount">{{ CarrinhoService::getQuantidadeItens() }}</span>
            </a>
        </div>
        <a class="header-item profile-container order-4" href="{{ route('site.perfil') }}">
            <i class="fas fa-user-circle"></i>
            <span class="d-none d-xl-block">Minha Conta</span>
        </a>
        <button class="header-item menu-container navbar-toggler collapsed order-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarmenu" aria-controls="navbarmenu" aria-expanded="false" aria-label="Mostrar Menu">
            <div class="d-flex flex-nowrap">
                <span class="fa-solid fa-bars"></span>
            </div>
        </button>
    </div>

    <x-site.menu></x-site.menu>

</header>
