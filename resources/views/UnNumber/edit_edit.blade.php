@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<!-- <h2>編集画面</h2> -->

    @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg') }}
        </p>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12">
        <form method="POST" action="{{ route('UnNumber.edit_update') }}" onsubmit="return false;" name="form">
                @csrf
          
                </br>
                <input type="hidden" name="id" id="id" value="{{ $input['id'] }}">
                <input type="hidden" name="TenantCode" id="TenantCode" value="{{ $input['TenantCode'] }}">
                <input type="hidden" name="TenantBranch" id="TenantBranch" value="{{ $input['TenantBranch'] }}">
                <input type="hidden" name="numberdiv" id="numberdiv" value="{{ $input['numberdiv'] }}">
                
                
                <div class="d-flex align-items-center">
                    <label for="numberdiv" class="form-label">採番区分</label>
                    <p class="form-control" id="numberdiv" name="numberdiv">{{ $get_numbers->DivName }}</p>
                </div>

               

                <div class="d-flex align-items-center">
                    <label for="editdiv" class="form-label">編集区分</label>
                    <select class="form-select enterTab" tabindex="" id="editdiv" name="editdiv" onchange="inputSymbol(this)" autofocus>
                        <option hidden value="{{ $input['editdiv'] }}">{{ $get_edits -> DivName }}</option><!-- javascriptとの兼ね合いでバリデートNGの場合は再選択にしてます。 -->
                        @foreach ($s_edits as $s_edit)
                            <option value="{{ $s_edit->DivNo }}">{{ $s_edit->DivName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('editdiv')) 
                        <div class="text-danger err_m">{{ $errors->first('editdiv') }}</div>
                    @endif
                    @if ($errors->has('symbol')) 
                        <div class="text-danger err_m">{{ $errors->first('symbol') }}</div>
                    @endif
                </div>

                <!-- 記号のデータがなければを三項演算子でCSS切り替え -->
                <div class="align-items-center" style="{{ !isset($input['symbol']) ? 'display: none' : 'display: flex' }}" id="symbol_wrap">
                    <label for="symbol" class="form-label">記号</label>
                    <input type="text" name="symbol" class="form-control" id="symbol" value="{{ $input['symbol'] }}" maxlength="3" onkeyup="inputCheck()">
                </div>

                <div class="d-flex align-items-center" id="lengs_wrap">
                    <label for="lengs" class="form-label">有効桁数</label>
                    <input type="text" name="lengs" class="form-control enterTab" id="lengs" value="{{ $input['lengs'] }}" maxlength="2" onkeyup="inputCheck()">
                </div>

                <div class="d-flex align-items-center">
                    <label for="initNumber" class="form-label">初期値</label>
                    <input type="text" name="initNumber" class="form-control enterTab" id="initNumber" value="{{ $input['initNumber'] }}" onkeyup="inputCheck()">
                    @if ($errors->has('initNumber')) 
                        <div class="text-danger err_m">{{ $errors->first('initNumber') }}</div>
                    @endif
                </div>
         

                <div class="d-flex align-items-center">
                    <label for="datediv" class="form-label">日付区分</label>
                    <select class="form-select enterTab" id="datediv" name="datediv">
                        @foreach ($s_dates as $s_date)
                            <option hidden value="{{ $input['datediv'] }}">{{ $get_dates->DivName }}</option>
                            <option value="{{ $s_date->DivNo }}" 
                            @if(old('datediv') == $s_date -> DivNo)
                                selected
                            @endif
                            >{{ $s_date->DivName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('datediv')) 
                        <div class="text-danger err_m">{{ $errors->first('datediv') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="numbercleardiv" class="form-label">クリア区分</label>
                    <select class="form-select enterTab" id="numbercleardiv" name="numbercleardiv">
                        @foreach ($s_numberClears as $s_numberClear)
                            <option hidden value="{{ $input['numbercleardiv'] }}">{{ $get_numberClears->DivName }}</option>
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
                        <input type="text" name="check" class="form-control" id="check" value="" tabindex="-1" readonly>
                        <!-- <div id="check" class="form-control" style="color:#999">採番後の番号が表示されます。</div> -->
                        <div id="err" class="ms-3" style="color:red"></div>
                    </div>
                </div>




                <div class="mt-5 d-flex">
                    <button type="button" onclick="history.back()" class="btn btn-primary me-4">戻 る</button>
                    <button type="button" class="btn btn-primary enterTab" tabindex="" onclick="submit()" id="enter">確 定</button>
                    <!-- <button type="submit" class="btn btn-primary enterTab" onclick="checkSubmit()">確 定</button> -->
                    <div id="check" class="ms-4 p-2"></div>
                </div>
            </form>

        </div>
    </div>
</div>



<script>
    // 編集区分が４と５の時は記号入力欄を出す
    // function inputSymbol(editdiv) {
    //     let selVal = editdiv.value;
    //     let target = document.getElementById("symbol_wrap");
    //     if(selVal ==  4 || selVal ==  5 ){
    //         target.style.display="flex";
    //     }else{
    //         target.style.display="none";
    //         symbol.value ="";
    //     } 
    // }


    

   
</script>




@endsection

