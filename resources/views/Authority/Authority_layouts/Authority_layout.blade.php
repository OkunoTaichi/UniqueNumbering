<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>@yield('Authority.Authority_layouts.Authority_layout.title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Authority.css') }}" rel="stylesheet">

    <!-- Bootstrap Table -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.css">
    

</head>
<body>
    <header>
       @include('Authority.Authority_layouts.Authority_header')
    </header>
    <main class="py-4">
        @yield('Authority.content')
    </main>
    <footer class="footer bg-dark  fixed-bottom">

    </footer>

    <script>
        // ここ微妙
        // エンターキーでタブの動き

        class FocusOrder {
            constructor() {
                this.nextElements = new Map();//tabOrderを記憶するマップ
                this.init=false;
            }
    
            initOrder() {
                //初期化
                //DOMを読み込んだ後に実行してください。
                
                if (this.init) {
                    //このコードをは複数回呼ばれるのを想定していません
                    console.log('すでに初期化済みです');
                    return;
                }
        
                this.init = true;
            
                //ターゲットとなる要素をここに指定してください。 
                let target = document.querySelectorAll(".enterTab");
                
                //tabIndexにマイナスを指定してあったら除外
                let wk1 = [];
                for (let i = 0; i < target.length; i++) {
                    if ( 0 <= target[i].tabIndex) {
                        wk1.push(target[i]);
                    }
                }
        
                //tabIndex順にソート
                let wk2=wk1.sort((a,b) => {
                    if (a.tabIndex == b.tabIndex) {
                        return 0;
                    } else if(a.tabIndex > b.tabIndex) {
                        return 1;
                    } else {
                        return -1;
                    }
                });
        
                //次にフォーカスするエレメントをMapにセット
                for (let i =0; i < wk2.length-1; i++) {
                    this.nextElements.set(wk2[i],wk2[i+1]);
                }
                this.nextElements.set(wk2[wk2.length-1],wk2[0]);
                
                //各エレメントにイベントをセット
                const keyevent = event => {
                    if (event.key === 'Enter') {
                        event.preventDefault();//eneterキーイベントの他の挙動を止めます。
                        if (event.srcElement) {
                            if (event.srcElement.tagName.toLowerCase().startsWith('textarea')) {
                                if (event.altKey==true) {
                                    //要素がテキストエリアでALTがついていたら現在の位置に改行(\n)を入れて抜ける
                                    const intPosition = event.srcElement.selectionStart;
                                    const wk = event.srcElement.value;
                                    event.srcElement.value=wk.substring(0,intPosition)+'\n'+wk.substring(intPosition);
                                    //キャレットの位置を修正
                                    event.srcElement.selectionStart=intPosition+1;
                                    event.srcElement.selectionEnd=intPosition+1;
                                    return;
                                }
                            }
                        }
                        this.nextElements.get(event.target).focus();
                    }
                };
            
                for (let i =0; i < wk2.length; i++) {
                wk2[i].onkeydown=function(event){keyevent(event)};
                }
            }
        };

        //クラスのインスタンスを作成
        //クラスの定義の後に記述する必要があります。
        let f = new FocusOrder();
        //初期化
        f.initOrder();


        //エンターキーで確定ボタンだけ動く
        var btn = document.getElementById('enter');
        if( btn != null ){
            btn.onkeydown = function(e){
                if (e.keyCode === 13) {
                    document.form.submit();
                }
            }
        }

        



    </script>

</body>
</html>
