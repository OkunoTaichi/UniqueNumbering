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

     
    
        // 採番後の番号出力
        function inputCheck() {
            // 日付をYYYYMMDDの書式で返すメソッド
            function formatDate(dt) {
                var y = dt.getFullYear();
                var m = ('00' + (dt.getMonth()+1)).slice(-2);
                var d = ('00' + dt.getDate()).slice(-2);
                return (y  + m  + d);
            }
            inputValueDate = formatDate(new Date());

            // 表示する値取得
            var inputValueInitNumber = document.getElementById( "initNumber" ).value;// 初期値
            var inputValueSymbol = document.getElementById( "symbol" ).value;// 記号
            // 0埋め
            var inputValueLength = document.getElementById( "lengs" ).value;// 有効桁数
            var symbolCount = inputValueSymbol.length;// 記号の桁数
            var initCount = inputValueInitNumber.length;// 初期値の桁数
            var lengthCount = inputValueLength;// 有効桁数

            // 連番
            var inputNormal = inputValueInitNumber.padStart(lengthCount, "0");
            // 日付＋連番
            var inputDay = inputValueInitNumber.padStart(lengthCount-8, "0");
            // 日付＋'-'＋連番
            var input_Day = inputValueInitNumber.padStart(lengthCount-9, "0");
            // 記号+連番
            var zeroCountSym = lengthCount - symbolCount;// 記号あり日付なし場合
            var inputSym = inputValueInitNumber.padStart(zeroCountSym, "0");// 記号あり日付なし場合(記号＋連番)
            // 記号+日付+連番
            var zeroCountSym = lengthCount - symbolCount;// 記号あり日付なし場合
            var inputSymDay = inputValueInitNumber.padStart(zeroCountSym-8, "0");// 記号あり日付なし場合(記号＋連番)

            //表示するパターン選定
            var inputValueEdit = document.getElementById( "editdiv" ).value;
            
            if( inputValueEdit == "1" ){
                document.getElementById( "check" ).value = inputNormal;
                // document.getElementById( "check" ).innerHTML = inputNormal; //HTML要素に入れたい場合
            }else if(inputValueEdit == "2"){
                document.getElementById( "check" ).value = inputValueDate + inputDay;
            }else if(inputValueEdit == "3"){
                document.getElementById( "check" ).value = inputValueDate + "-" + input_Day;
            }else if(inputValueEdit == "4"){
                document.getElementById( "check" ).value = inputValueSymbol + inputSym;
            }else if(inputValueEdit == "5"){
                document.getElementById( "check" ).value = inputValueSymbol + inputValueDate + inputSymDay;
            }else{
            }

            // 採番後の番号が有効桁数を超えた時の赤文字
            $fullInput = document.getElementById( "check" ).value.length;
            // $fullInput = document.getElementById( "check" ).innerHTML.length;
            let target = document.getElementById("check");
            if($fullInput > inputValueLength){
                target.style.color="red";
                document.getElementById( "err" ).innerHTML = '有効桁数を超えています。';
            }else{
                target.style.color="black";
                document.getElementById( "err" ).innerHTML = '';
            }
        }



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


        // 記号関連が選択されたら記号にフォーカス。それ以外はスルー
        function inputSymbol(editdiv) {
            let selVal = editdiv.value;
            let target = document.getElementById("symbol_wrap");
            let route = document.getElementById("editdiv");
            let route2 = document.getElementById("symbol");
            if(selVal ==  4 || selVal ==  5 ){
                target.style.display="flex";
              
                route.onkeydown = function(e){
                    if ( e.keyCode === 13) {
                        document.getElementById("symbol").focus();
                    }
                }

                route2.onkeydown = function(e){
                    if ( e.keyCode === 13) {
                        document.getElementById("lengs").focus();
                    }
                }
                    
            }else{
                target.style.display="none";

                route.onkeydown = function(e){
                    if ( e.keyCode === 13) {
                        document.getElementById("lengs").focus();
                    }
                }
            } 
        }

        // 入力したらエンターで次にフォーカス
        // function symbolNext(symbol) {
        //     let symVal = symbol.value;
        //     let target = document.getElementById("symbol");
        //     if(symVal != null){
        //         document.getElementById("lengs").focus();
        //     }
        // }
     


    </script>
    <!-- <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/bootstrap-table.min.js"></script> -->
</body>
</html>
