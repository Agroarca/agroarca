@php
    use App\Services\Site\CarrinhoService;
@endphp
<nav class="py-2 contact">
    <div class="container contact-container d-flex flex-wrap" style="justify-content: space-between;">

        <span class="phone"><i class="fas fa-phone-alt"></i>+55 54 9902-0345</span>
        <span class="mail"><i class="fas fa-envelope"></i>contato@agroarca.com.br</span>

        {{-- @TODO: Precisa implementar endpoint no backend, e pegar valor da section aqui --}}
        {{-- Tambem verificar se o usuario esta autenticado e se tem endereco cadastrado antes de mostrar --}}
        <span class="delivery" id="delivery-content"><i class="fa fa-truck"></i><b>Onde deseja a entrega?</b> <small>(temporario)</small></span>


    </div>
</nav>

@include('site.adicionais.modals.delivery-information')

<header class="py-3 mb-4">

    <div class="container main">
        <div class="header-item text-decoration-none logo-container">
            <a href="{{ url('/') }}">
                <img class="logo" src="{{ asset('img/logo.png') }}">
            </a>
        </div>
        <div class="header-item search-container">
            <input placeholder="Pequisar produtos..." type="text" class="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
        <div class="header-item arca-container">
            <a href="{{ route('site.carrinho') }}"><i class="fas fa-th-large"></i></a>
        </div>
        <div class="header-item arca-container ">
            <a href="{{ route('site.carrinho') }}"><i class="fas fa-shopping-cart"></i></a>
            <span class="cart-placeholder" id="cart-amount">{{ CarrinhoService::getQuantidadeItens() }}</span>
        </div>
        <a class="header-item profile-container" href="{{ route('index') }}">
            <i class="fas fa-user-circle"></i>
            Minha Conta
        </a>
        <a class="header-item profile-container" href="{{ route('admin.inicio') }}">
            <i class="fa-solid fa-chart-line"></i>
            Painel
        </a>
    </div>

    <div class="container">
        <div class="row menu-content">
            <x-site.menu></x-site.menu>
        </div>
    </div>
</header>
