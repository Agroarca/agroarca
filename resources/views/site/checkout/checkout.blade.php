@section('vue-app', true)

@push('pre-js')
    <script>
        window.checkoutDados = {{ Illuminate\Support\Js::from($checkoutDados) }}
    </script>
@endpush

<x-site-checkout>
    <checkout></checkout>
    <div id="modal-novo-endereco">
    </div>
</x-site-checkout>
