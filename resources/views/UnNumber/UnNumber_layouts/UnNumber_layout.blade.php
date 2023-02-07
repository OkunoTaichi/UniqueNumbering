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

        .form-control,
        .form-select{
            width: 300px;
       
            margin: 0 0.5rem 0.5rem 0;
        }
        .form-label{
            width: 250px;
        }
        .err_message{
            width: 200px;
            padding: 0 20px
        }
        .in_active,.is_active{
            padding: 0.5rem;
        }

    </style>
    <script>
        function checkSubmit(){
            if(window.confirm('変更してよろしいですか？')){
                return true;
            } else {
                return false;
            }
        }
        function inputSubmit(){
            if(window.confirm('登録してよろしいですか？')){
                return true;
            } else {
                return false;
            }
        }
    
        function checkDestroy(){
            var flag = false; 
            for(var i=0; i<document.url.id.length;i++){
                if(document.url.id[i].checked){ 
                    flag = true; 
                }
            }
            if(!flag){ 
                alert("項目が選択されていません。");
                return false;
            }
            if(window.confirm('削除してよろしいですか？')){
                return true;
            } else {
                return false;
            }
        }

        
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script>
</body>
</html>
