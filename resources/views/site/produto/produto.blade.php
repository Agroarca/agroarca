<x-site>
    <section class="content produto">
        <div class="container flex-column">
            <x-site.breadcrumb-categoria :categoria="$produto->categoria"></x-site.breadcrumb-categoria>
            <div class="detalhe">
                <div class="imagens">
                    @include('site.produto.imagens', ['imagens' => $produto->imagens])
                </div>
                <div class="infos">
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
</x-site>
