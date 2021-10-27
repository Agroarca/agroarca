<header>
    <div class="contact">
        <div class="container contact-container">
            <span class="phone"><i class="fas fa-phone-alt"></i>+55 54 9902-0345</span>
            <span class="mail"><i class="fas fa-envelope"></i>contato@agroarca.com.br</span>
        </div>
    </div>

    <div class="main container">
        <div class="logo-container">
            <img class="logo" src="{{ asset('img/logo.png') }}">
        </div>
        <div class="search-container">
            <input type="text" class="search">
        </div>
        <div class="arca-container">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="profile-container">
            <i class="fas fa-user"></i>
            <a href="{{ route('dashboard') }}">Minha Conta</a>
        </div>
    </div>

    <div class="menu-content">
        <x-site.menu></x-site.menu>
    </div>
</header>
