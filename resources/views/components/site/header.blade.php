<nav class="py-2 contact">
    <div class="container contact-container d-flex flex-wrap">

        <span class="phone"><i class="fas fa-phone-alt"></i>+55 54 9902-0345</span>
        <span class="mail"><i class="fas fa-envelope"></i>contato@agroarca.com.br</span>

    </div>
</nav>
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
            <span class="cart-placeholder" id="cart-amount">7</span>
        </div>
        <a class="header-item profile-container" href="{{ route('dashboard') }}">
            <i class="fas fa-user-circle"></i>
            Minha Conta
        </a>
    </div>

    <div class="container">
        <div class="row menu-content">
            <x-site.menu></x-site.menu>
        </div>
    </div>
</header>
