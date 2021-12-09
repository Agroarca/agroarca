<x-site>
    <section class="content listagem">
        <div class="container">
            @isset($categoria)
                <x-site.breadcrumb-categoria :categoria="$categoria"></x-site.breadcrumb-categoria>
            @endisset

            <div class="produtos">
                @foreach ($produtos as $produto)
                    @include('site.listagem.produto', $produto)
                @endforeach
            </div>
        </div>
    </section>
</x-site>
