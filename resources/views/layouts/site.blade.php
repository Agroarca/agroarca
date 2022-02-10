<html>

<head>
    {{-- <link href="{{ asset('bootstrap5/css/bootstrap.css') }}" rel="stylesheet"> --}}
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/style.css') }}" rel="stylesheet">


</head>

<body>
    <div class="reference"></div>
    <x-site.header></x-site.header>

    {{ $slot }}

    {{-- <script src="{{ asset('bootstrap5/js/bootstrap.js') }}"></script> --}}
    <script src="{{ mix('js/script.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
</body>
</html>
