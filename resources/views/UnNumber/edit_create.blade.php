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
                            @if(old('TenantBranch') == $s_tenantBranch->TenantBranchName)
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
                    <label for="numberdiv" class="form-label">登録名称</label>
                    <select class="form-select" id="numberdiv" name="numberdiv">
                        @foreach ($s_numbers as $s_number)
                            <option value="{{ $s_number->number_id }}" 
                            @if(old('number_id') == $s_number->number_name)
                                selected
                            @endif
                            >{{ $s_number->number_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('number_id')) 
                        <div class="text-danger err_m">{{ $errors->first('number_id') }}</div>
                    @endif
                </div>
                <div class="d-flex align-items-center">
                    <label for="initNumber" class="form-label">初期値</label>
                    <input type="text" name="initNumber" class="form-control" id="initNumber" value="{{ old('initNumber') }}">
                </div>

                <div class="d-flex align-items-center">
                    <label for="symbol" class="form-label">記号</label>
                    <input type="text" name="symbol" class="form-control" id="symbol" value="{{ old('symbol') }}">
                </div>

                <div class="d-flex align-items-center">
                    <label for="editdiv" class="form-label">編集区分</label>
                    <select class="form-select" id="editdiv" name="editdiv">
                        @foreach ($s_edits as $s_edit)
                            <option value="{{ $s_edit->edit_id }}" 
                            @if(old('edit_id') == $s_edit->edit_name)
                                selected
                            @endif
                            >{{ $s_edit->edit_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('edit_id')) 
                        <div class="text-danger err_m">{{ $errors->first('edit_id') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="datediv" class="form-label">日付区分</label>
                    <select class="form-select" id="datediv" name="datediv">
                        @foreach ($s_dates as $s_date)
                            <option value="{{ $s_date->date_id }}" 
                            @if(old('date_id') == $s_date -> date_name)
                                selected
                            @endif
                            >{{ $s_date->date_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('edit_id')) 
                        <div class="text-danger err_m">{{ $errors->first('date_id') }}</div>
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

@endsection

