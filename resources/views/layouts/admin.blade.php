@extends('adminlte::page')

@push('css')
    @isset($css)
        {{ $css }}
    @endisset

    <link rel="stylesheet" href="{{ mix('css/vendor-admin.css') }}">
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">

    <script defer src="{{ mix('js/vendor-admin.js') }}"></script>
    <script defer src="{{ mix('js/admin.js') }}"></script>
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
    @isset($js)
        {{ $js }}
    @endisset
@endpush
