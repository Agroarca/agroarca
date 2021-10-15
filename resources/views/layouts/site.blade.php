<html>
    <head>
        <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
        <link href="{{ mix('css/site.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="reference"></div>
        <x-site.header></x-site.header>

        {{ $slot }}
    </body>
</html>
