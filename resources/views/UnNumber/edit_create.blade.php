@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<h2>オリジナル編集区分作成画面</h2>
<br/>

    @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg') }}
        </p>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ route('UnNumber.edit_confirm') }}">
                @csrf

                <div class="d-flex align-items-center">
                    <label for="TenantCode" class="form-label">テナントCD</label>
                    <select class="form-select" id="TenantCode" name="TenantCode">
                        @foreach ($s_tenants as $s_tenant)
                            <option value="{{ $s_tenant->TenantCode }}" 
                            @if(old('TenantCode') == $s_tenant->TenantCode)
                                selected
                            @endif
                            >{{ $s_tenant->CompanyName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('TenantCode')) 
                        <div class="text-danger err_m">{{ $errors->first('TenantCode') }}</div>
                    @endif

                    <select class="form-select" id="TenantBranch" name="TenantBranch">
                        @foreach ($s_tenantBranchs as $s_tenantBranch)
                            <option value="{{ $s_tenantBranch->TenantBranch }}" 
                            @if(old('TenantBranch') == $s_tenantBranch->TenantBranch)
                                selected
                            @endif
                            >{{ $s_tenantBranch->TenantBranchName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('TenantBranch')) 
                        <div class="text-danger err_m">{{ $errors->first('TenantBranch') }}</div>
                    @endif
                </div>
                <br/>

                
                <div class="d-flex align-items-center">
                    <label for="numberdiv" class="form-label">採番区分</label>
                    <select class="form-select" id="numberdiv" name="numberdiv">
                        @foreach ($s_numbers as $s_number)
                            <option value="{{ $s_number->number_id }}" 
                            @if(old('numberdiv') == $s_number->number_id)
                                selected
                            @endif
                            >{{ $s_number->number_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('numberdiv')) 
                        <div class="text-danger err_m">{{ $errors->first('numberdiv') }}</div>
                    @endif
                </div>
                <div class="d-flex align-items-center">
                    <label for="initNumber" class="form-label">初期値</label>
                    <input type="text" name="initNumber" class="form-control" id="initNumber" value="{{ old('initNumber') }}">
                    @if ($errors->has('initNumber')) 
                        <div class="text-danger err_m">{{ $errors->first('initNumber') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="editdiv" class="form-label">編集区分</label>
                    <select class="form-select" id="editdiv" name="editdiv" onchange="inputSymbol(this)">
                        <option hidden>選択してください</option><!-- javascriptとの兼ね合いでバリデートNGの場合は再選択にしてます。 -->
                        @foreach ($s_edits as $s_edit)
                            <option value="{{ $s_edit->edit_id }}" >{{ $s_edit->edit_name }}</option>
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
                    <input type="text" name="symbol" class="form-control" id="symbol" value="{{ old('symbol') }}" maxlength="3">
                </div>

                <div class="d-flex align-items-center">
                    <label for="datediv" class="form-label">日付区分</label>
                    <select class="form-select" id="datediv" name="datediv">
                        @foreach ($s_dates as $s_date)
                            <option value="{{ $s_date->date_id }}" 
                            @if(old('datediv') == $s_date -> date_id)
                                selected
                            @endif
                            >{{ $s_date->date_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('datediv')) 
                        <div class="text-danger err_m">{{ $errors->first('datediv') }}</div>
                    @endif
                </div>

                
                <div class="mt-5 d-inline-block">
                
                    <button type="submit" class="btn btn-primary ms-4">
                        確 認
                    </button>
                </div>
            </form>
        
        </div>
    </div>
</div>


<script>
    // function GetSelectedTextValue(language) {
    //     let sleTex = language.options[language.selectedIndex].innerHTML;
    //     let selVal = language.value;
    //     alert("Selected Text: " + sleTex + " Value: " + selVal);
    // }
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

