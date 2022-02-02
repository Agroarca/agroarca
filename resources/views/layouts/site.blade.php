<html>

<head>
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/site.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap5/css/bootstrap.css') }}" rel="stylesheet">
    {{-- <script defer src="{{ mix('js/site.js') }}"></script> --}}
</head>

<body>
    <div class="reference"></div>
    <x-site.header></x-site.header>

    {{ $slot }}

    <script src="{{ asset('bootstrap5/js/bootstrap.js') }}"></script>
</body>

</html>
