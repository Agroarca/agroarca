@extends('adminlte::page')

@push('css')
    @isset($css)
        {{ $css }}
    @endisset

    <link rel="stylesheet" href="{{ mix('css/vendor-admin.css') }}">
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
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
    <script src="{{ mix('js/vendor-admin.js') }}"></script>
    <script src="{{ mix('js/admin.js') }}"></script>
    @isset($js)
        {{ $js }}
    @endisset

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').each(function () {
                $(this).tooltip({ container: this })
            })
        })
    </script>
@endpush
