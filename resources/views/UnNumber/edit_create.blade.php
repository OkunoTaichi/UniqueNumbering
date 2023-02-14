@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<!-- <h2>オリジナル編集区分作成画面</h2> -->
<br/>

    @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg') }}
        </p>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ route('UnNumber.edit_confirm') }}" onsubmit="return false;">
                @csrf

                <input type="hidden" id="TenantCode" name="TenantCode" value="{{ $tenantCode }}">
                <input type="hidden" id="TenantBranch" name="TenantBranch" value="{{ $tenantBranch }}">

                <div class="d-flex align-items-center">
                    <label for="numberdiv" class="form-label">採番区分</label>
                    <select class="form-select enterTab" tabindex="" id="numberdiv" name="numberdiv" autofocus>
                        @foreach ($s_numbers as $s_number)
                            <option value="{{ $s_number->DivNo }}" 
                            @if(old('numberdiv') == $s_number->DivNo)
                                selected
                            @endif
                            >{{ $s_number->DivNo }} : {{ $s_number->DivName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('numberdiv')) 
                        <div class="text-danger err_m">{{ $errors->first('numberdiv') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="editdiv" class="form-label">編集区分</label>
                    <select class="form-select enterTab" tabindex="" id="editdiv" name="editdiv" onchange="inputSymbol(this)">
                        <!-- <option hidden value="">選択してください</option>javascriptとの兼ね合いでバリデートNGの場合は再選択にしてます。 -->
                        @foreach ($s_edits as $s_edit)
                            <option value="{{ $s_edit->DivNo }}">{{ $s_edit->DivNo }} : {{ $s_edit->DivName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('editdiv')) 
                        <div class="text-danger err_m">{{ $errors->first('editdiv') }}</div>
                    @endif
                    @if ($errors->has('symbol')) 
                        <div class="text-danger err_m">{{ $errors->first('symbol') }}</div>
                    @endif
                </div>

                <div class="align-items-center" style="display: none;" id="symbol_wrap">
                    <label for="symbol" class="form-label">記号</label>
                    <input type="text" name="symbol" class="form-control" id="symbol" value="" maxlength="3" onkeyup="inputCheck()">

                </div>

                <div class="d-flex align-items-center" id="lengs_wrap">
                    <label for="lengs" class="form-label">有効桁数</label>
                    <input type="text" name="lengs" class="form-control enterTab" tabindex="" id="lengs" value="{{ old('lengs') }}" maxlength="2" onkeyup="inputCheck()">
                    @if ($errors->has('lengs')) 
                        <div class="text-danger err_m">{{ $errors->first('lengs') }}</div>
                    @endif
                </div>
                <div class="d-flex align-items-center">
                    <label for="initNumber" class="form-label">初期値</label>
                    <input type="text" name="initNumber" class="form-control enterTab" tabindex="" id="initNumber" value="{{ old('initNumber') }}" onkeyup="inputCheck()">
                    @if ($errors->has('initNumber')) 
                        <div class="text-danger err_m">{{ $errors->first('initNumber') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="datediv" class="form-label">日付区分</label>
                    <select class="form-select enterTab" tabindex="" id="datediv" name="datediv">
                        @foreach ($s_dates as $s_date)
                            <option value="{{ $s_date->DivNo }}" 
                            @if(old('datediv') == $s_date -> DivNo)
                                selected
                            @endif
                            >{{ $s_date->DivNo }} : {{ $s_date->DivName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('datediv')) 
                        <div class="text-danger err_m">{{ $errors->first('datediv') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="numbercleardiv" class="form-label">クリア区分</label>
                    <select class="form-select enterTab" tabindex="" id="numbercleardiv" name="numbercleardiv">
                        @foreach ($s_numberClears as $s_numberClear)
                            <option value="{{ $s_numberClear->DivNo }}" 
                            @if(old('numbercleardiv') == $s_numberClear -> DivNo)
                                selected
                            @endif
                            >{{ $s_numberClear->DivNo }} : {{ $s_numberClear->DivName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('numbercleardiv')) 
                        <div class="text-danger err_m">{{ $errors->first('numbercleardiv') }}</div>
                    @endif
                </div>

                <div class="align-items-center d-flex" id="symbol_wrap">
                    <label for="" class="form-label">採番後の番号目安</label>
                    <div class="">
                        <input type="text" name="check" class="form-control enterTab" tabindex="" id="check" value="" readonly>
                        <!-- <div id="check" class="form-control" style="color:#999">採番後の番号が表示されます。</div> -->
                        <div id="err" class="ms-3" style="color:red"></div>
                    </div>
                </div>
                
                <div class="mt-5 d-flex">
                    <button type="button" onclick="history.back()" class="btn btn-primary me-4">キャンセル</button>
                    <button type="button" class="btn btn-primary enterTab" tabindex="" onclick="submit();">確 認</button>
                </div>
            </form>
        
        </div>
    </div>
</div>





<script>
    // function inputSymbol(editdiv) {
    //     let selVal = editdiv.value;
    //     let target = document.getElementById("symbol_wrap");
    //     let symbol = document.getElementById("symbol");
    //     if(selVal ==  4 || selVal ==  5 ){
    //         target.style.display="flex";
      
    //     }else{
    //         target.style.display="none";
    //         symbol.value ="";
    //     } 
    // }
 

    // // 採番後の番号出力
    // function inputCheck() {
    //     // 日付をYYYYMMDDの書式で返すメソッド
    //     function formatDate(dt) {
    //         var y = dt.getFullYear();
    //         var m = ('00' + (dt.getMonth()+1)).slice(-2);
    //         var d = ('00' + dt.getDate()).slice(-2);
    //         return (y  + m  + d);
    //     }
    //     inputValueDate = formatDate(new Date());

    //     // 表示する値取得
    //     var inputValueInitNumber = document.getElementById( "initNumber" ).value;// 初期値
    //     var inputValueSymbol = document.getElementById( "symbol" ).value;// 記号
    //     // 0埋め
    //     var inputValueLength = document.getElementById( "lengs" ).value;// 有効桁数
    //     var symbolCount = inputValueSymbol.length;// 記号の桁数
    //     var initCount = inputValueInitNumber.length;// 初期値の桁数
    //     var lengthCount = inputValueLength;// 有効桁数

    //     // 連番
    //     var inputNormal = inputValueInitNumber.padStart(lengthCount, "0");
    //     // 日付＋連番
    //     var inputDay = inputValueInitNumber.padStart(lengthCount-8, "0");
    //     // 日付＋'-'＋連番
    //     var input_Day = inputValueInitNumber.padStart(lengthCount-9, "0");
    //     // 記号+連番
    //     var zeroCountSym = lengthCount - symbolCount;// 記号あり日付なし場合
    //     var inputSym = inputValueInitNumber.padStart(zeroCountSym, "0");// 記号あり日付なし場合(記号＋連番)
    //     // 記号+日付+連番
    //     var zeroCountSym = lengthCount - symbolCount;// 記号あり日付なし場合
    //     var inputSymDay = inputValueInitNumber.padStart(zeroCountSym-8, "0");// 記号あり日付なし場合(記号＋連番)

    //     //表示するパターン選定
    //     var inputValueEdit = document.getElementById( "editdiv" ).value;
        
    //     if( inputValueEdit == "1" ){
    //         document.getElementById( "check" ).value = inputNormal;
    //         // document.getElementById( "check" ).innerHTML = inputNormal; //HTML要素に入れたい場合
    //     }else if(inputValueEdit == "2"){
    //         document.getElementById( "check" ).value = inputValueDate + inputDay;
    //     }else if(inputValueEdit == "3"){
    //         document.getElementById( "check" ).value = inputValueDate + "-" + input_Day;
    //     }else if(inputValueEdit == "4"){
    //         document.getElementById( "check" ).value = inputValueSymbol + inputSym;
    //     }else if(inputValueEdit == "5"){
    //         document.getElementById( "check" ).value = inputValueSymbol + inputValueDate + inputSymDay;
    //     }else{
    //     }

    //     // 採番後の番号が有効桁数を超えた時の赤文字
    //     $fullInput = document.getElementById( "check" ).value.length;
    //     // $fullInput = document.getElementById( "check" ).innerHTML.length;
    //     let target = document.getElementById("check");
    //     if($fullInput > inputValueLength){
    //         target.style.color="red";
    //         document.getElementById( "err" ).innerHTML = '有効桁数を超えています。';
    //     }else{
    //         target.style.color="black";
    //         document.getElementById( "err" ).innerHTML = '';
    //     }
        
    // }




  


    







</script>

@endsection

