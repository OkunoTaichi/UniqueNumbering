@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<!-- <h2>コピーペースト</h2> -->
<br/>

    @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg') }}
        </p>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ route('UnNumber.edit_confirm') }}"  onsubmit="return false;" name="form">
                @csrf

                <input type="hidden" id="TenantCode" name="TenantCode" value="{{ $tenantCode }}">
                <input type="hidden" id="TenantBranch" name="TenantBranch" value="{{ $tenantBranch }}">

                
                
                <div class="d-flex align-items-center">
                    <label for="numberdiv" class="form-label">採番区分</label>
                    <select class="form-select enterTab" id="numberdiv" name="numberdiv" autofocus>
                    <option hidden value="{{ session('numberdiv') }}" selected >{{ session('numberName') }}</option>
                        @foreach ($s_numbers as $s_number)
                            <option value="{{ $s_number->DivNo }}">{{ $s_number->DivNo }} : {{ $s_number->DivName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('numberdiv')) 
                        <div class="text-danger err_m">{{ $errors->first('numberdiv') }}</div>
                    @endif
                </div>
                

                <div class="d-flex align-items-center">
                    <label for="editdiv" class="form-label">編集区分</label>
                    <select class="form-select enterTab" id="editdiv" name="editdiv" onchange="inputSymbol(this)">
                        <option hidden value="{{ session('editdiv') }}">{{ session('editName') }}</option><!-- javascriptとの兼ね合いでバリデートNGの場合は再選択にしてます。 -->
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

                @if(session('symbol') != null)
                <div class="align-items-center" style="display: flex;" id="symbol_wrap">
                @else
                <div class="align-items-center" style="display: none;" id="symbol_wrap">
                @endif
                    <label for="symbol" class="form-label">記号</label>
                    <input type="text" name="symbol" class="form-control" id="symbol" value="{{ session('symbol') }}" maxlength="3" onkeyup="inputCheck()">
                </div>

                <div class="d-flex align-items-center" id="lengs_wrap">
                    <label for="lengs" class="form-label">有効桁数</label>
                    <input type="text" name="lengs" class="form-control enterTab" id="lengs" value="{{ session('lengs') }}" maxlength="2" onkeyup="inputCheck()">
                </div>
                
                <div class="d-flex align-items-center">
                    <label for="initNumber" class="form-label">初期値</label>
                    <input type="text" name="initNumber" class="form-control enterTab" id="initNumber" value="{{ session('initNumber') }}" onkeyup="inputCheck()">
                    @if ($errors->has('initNumber')) 
                        <div class="text-danger err_m">{{ $errors->first('initNumber') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="datediv" class="form-label">日付区分</label>
                    <select class="form-select enterTab" id="datediv" name="datediv">
                        <option hidden value="{{ session('datediv') }}">{{ session('dateName') }}</option>
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
                    <select class="form-select enterTab" id="numbercleardiv" name="numbercleardiv">
                        <option hidden value="{{ session('numbercleardiv') }}">{{ session('numberclearName') }}</option>
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
                        <input type="text" name="check" class="form-control enterTab" id="check" value="" tabindex="-1" readonly>
                        <!-- <div id="check" class="form-control" style="color:#999">採番後の番号が表示されます。</div> -->
                        <div id="err" class="ms-3" style="color:red"></div>
                    </div>
                </div>

                <div class="mt-5 d-flex">
                    <button type="button" onclick="history.back()" class="btn btn-primary me-4">戻 る</button>
                    <button type="submit" class="btn btn-primary enterTab" tabindex="" onclick="submit()" id="enter">確 認</button>
                    <div id="check" class="ms-4 p-2"></div>
                </div>
                
            </form>
        
        </div>
    </div>
</div>



<script>

    function inputSymbol(editdiv) {
        let selVal = editdiv.value;
        let target = document.getElementById("symbol_wrap");
        if(selVal ==  4 || selVal ==  5 ){
            target.style.display="flex";
        }else{
            target.style.display="none";
            symbol.value ="";
        } 
    }

</script>

@endsection

