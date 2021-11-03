@extends('adminlte::page')

@push('css')
    @isset($css)
        {{ $css }}
    @endisset

    <link rel="stylesheet" href="{{ mix('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ mix('css/style.css') }}">
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

{{-- Inclui o script de CropperJS dinamicamente --}}
@hasSection('CropperJS')
    @once
        @prepend('js')
            <script src="{{ mix('js/cropper.js') }}"></script>
        @endprepend
    @endonce
@endif
