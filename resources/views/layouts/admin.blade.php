@extends('adminlte::page')

@push('css')
    @isset($css)
        {{ $css }}
    @endisset
@endpush

@section('content_header')
    @isset($header)
        {{ $header }}
    @endisset
@endsection

@section('content')
    {{ $slot }}
@endsection

@push('js')
    <script src="{{ mix('js/app.js') }}"></script>
    @isset($js)
        {{ $js }}
    @endisset
@endpush

{{-- Inclui o script de inputmask dinamicamente --}}
@hasSection('InputMask')
    @once
        @prepend('js')
            <script src="{{ mix('js/inputmask.js') }}"></script>
        @endprepend
    @endonce
@endif
