<nav class="navbar navbar-expand-md">
    <div class="container-fluid menu-container">
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarmenu" aria-controls="navbarmenu" aria-expanded="false" aria-label="Mostrar Menu">
            <span class="fa-solid fa-bars navbar-toggler-icon"></span>
        </button>
        <div class="row menu-content collapse navbar-collapse" id="navbarmenu">
            <ul class="menu navbar-nav">
                <li class="nav-item"></li>
                <li class="nav-item">
                    <a class="menu-item" href="{{ route('site.categoria', null) }}">Todas as Categorias</a>
                </li>
                @if (!is_null(\App\Models\Estoque\Produto::first()))
                    <li class="nav-item">
                        <a class="menu-item" href="{{ route('site.produto', \App\Models\Estoque\Produto::first()) }}">Produto Exemplo</a>
                    </li>
                @endif
                <li class="nav-item"></li>
            </ul>
        </div>
    </div>
</nav>
