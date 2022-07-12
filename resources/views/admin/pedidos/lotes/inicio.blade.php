<x-admin>
    <x-slot name='header'>
        <div class="row">
            <div class="col-sm-8">
                <h1>Lotes do item {{ $pedidoItem->produtoNome }}</h1>
            </div>
            <div class="col-sm-4 pt-3 pt-sm-0">
                <a href="#" class="btn btn-primary float-sm-right"><i class="fas fa-plus-circle pr-1"></i>Novo Lote</a>
            </div>
        </div>
    </x-slot>
</x-admin>
