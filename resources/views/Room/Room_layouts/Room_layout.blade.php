<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>部屋マスタ</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ asset('js/RoomType.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Person.css') }}" rel="stylesheet">
    <link href="{{ asset('css/RoomType.css') }}" rel="stylesheet">

    <!-- Bootstrap Table -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">
    

</head>
<body>
    <header>
       @include('layouts.header_layout')
    </header>
    <main class="py-4">
        @yield('Room.content')
    </main>
    <footer class="footer bg-dark  fixed-bottom">

    </footer>

    <script>


    </script>

</body>
</html>
