<html>

<head>
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/style.css') }}" rel="stylesheet">
</head>

<body>
    @stack('pre-js')
    <div id="vue-app">
        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div id="erros-container" class="toast-container position-absolute top-0 end-0 p-3"></div>
        </div>

        <div class="reference"></div>
        <x-site.header></x-site.header>

        {{ $slot }}

        <x-site.footer></x-site.footer>
    </div>

    <script src="{{ mix('js/script.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    @hasSection('vue-app')
        @once
            <script src="{{ mix('js/vue.js') }}"></script>
        @endonce
    @endif
    @stack('js')
</body>

</html>
