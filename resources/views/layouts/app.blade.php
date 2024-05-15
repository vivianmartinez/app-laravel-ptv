<!DOCTYPE html>
<html lang="EN">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App PTV</title>

        <!-- Scripts -->
        <script src="{{asset('js/script.js')}}"></script>
        <script src="{{asset('js/ajax.js')}}"></script>
        @vite(['resources/sass/app.scss','resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <main>
            @yield('content')
        </main>
    </body>
</html>
