@push('pre-js')
    <script>
        window.carrinhoDados = JSON.parse({{ Illuminate\Support\Js::from($carrinho) }})
    </script>
@endpush

<carrinho></carrinho>
