@section('vue-app', true)

<script>
    window.pedidoDados = {{ Illuminate\Support\Js::from($pedido) }}
</script>

<x-admin>
    <x-slot name='header'>
        <h1>Novo Pedido</h1>
    </x-slot>

    <admin-pedido></admin-pedido>
</x-admin>
