@section('vue-app', true)
<x-site>
    <section class="content produto">
        <div class="container flex-column">
            <x-site.breadcrumb-categoria :categoria="$produto->categoria"></x-site.breadcrumb-categoria>
            <div class="d-flex flex-column flex-lg-row">
                <div class="imagens col-lg-6 pe-lg-3">
                    @include('site.produto.imagens', ['imagens' => $produto->imagens])
                </div>
                <div class="infos col-lg-6 ps-lg-3 pt-5 pt-lg-0">
                    @include('site.produto.infos', ['produto' => $produto, 'precoProduto' => $precoProduto])
                </div>
            </div>
            @if ($produto->descricao_longa)
                <div class="mais-infos">
                    <div class="descricao-longa-header">
                        <h3>Descrição</h3>
                    </div>
                    <div class="descricao-longa">
                        <p>{{ $produto->descricao_longa }}</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <x-site.recently-viewed></x-site.recently-viewed>

    @include('site.adicionais.business-values')
</x-site>
