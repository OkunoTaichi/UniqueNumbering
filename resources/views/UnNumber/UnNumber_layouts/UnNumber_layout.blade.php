<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>@yield('UnNumber.UnNumber_layouts.UnNumber_layout.title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap Table -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">
    

</head>
<body>
    <header>
       @include('UnNumber.UnNumber_layouts.UnNumber_header')
    </header>
    <main class="py-4">
        @yield('UnNumber.content')
    </main>
    <footer class="footer bg-dark  fixed-bottom">

    </footer>
    <style>

        

    </style>
    <script>
        


    </script>
    <!-- <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script> -->
</body>
</html>
