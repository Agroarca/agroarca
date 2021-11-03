<nav class="breadcrumb" aria-label="breadcrumb">
    @foreach ($breadcrumbLinks as $link)
        <a href="{{ $link->link }}" class="breadcrumb-link">{{ $link->texto }}</a>
    @endforeach
</nav>
