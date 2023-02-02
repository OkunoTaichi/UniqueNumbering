@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<h2>テスト確認画面</h2>
<br/>

    @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg') }}
        </p>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ route('UnNumber.edit_store') }}">
                @csrf
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <label for="" class="form-label">テナントCD</label>
                        <p class="form-control">{{ $inputs['TenantCode'] }} - {{ $inputs['TenantBranch'] }}</p>
                    </div>
    
                    <div class="">
                        <div class="d-flex align-items-center">
                            <label for="TenantCode" class="form-label" style="padding-left:100px">テナント会社名</label>
                            <input type="hidden" name="TenantCode" class="form-control" id="TenantCode" value="{{ $inputs['TenantCode'] }}">
                            <p class="" style="margin-bottom: 0.5rem;">{{ $t_tenant->CompanyName }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="TenantBranch" class="form-label" style="padding-left:100px">テナント施設名</label>
                            <input type="hidden" name="TenantBranch" class="form-control" id="TenantBranch" value="{{ $inputs['TenantBranch'] }}">
                            <p class="" style="margin-bottom: 0.5rem;">{{ $t_tenantBranch->TenantBranchName }}</p>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="d-flex align-items-center">
                    <label for="numberdiv" class="form-label">登録名称</label>
                    <input type="hidden" name="numberdiv" class="form-control" id="numberdiv" value="{{ $inputs['numberdiv'] }}">
                    <p class="form-control">{{ $t_number->number_name }}</p>
                </div>

                <div class="d-flex align-items-center">
                    <label for="initNumber" class="form-label">初期値</label>
                    <input type="hidden" name="initNumber" class="form-control" id="initNumber" value="{{ $inputs['initNumber'] }}">
                    <p class="form-control">
                        @if($inputs['initNumber'] == null)
                            なし
                        @else
                            {{ $inputs['initNumber'] }}
                        @endif
                    </p>
                </div>

                <div class="d-flex align-items-center">
                    <label for="symbol" class="form-label">記号</label>
                    <input type="hidden" name="symbol" class="form-control" id="symbol" value="{{ $inputs['symbol'] }}">
                    <p class="form-control">
                    @if($inputs['symbol'] == null)
                        なし
                    @else
                        {{ $inputs['symbol'] }}        
                    @endif
                    </p>
                </div>

                <div class="d-flex align-items-center">
                    <label for="editdiv" class="form-label">編集区分</label>
                    <input type="hidden" name="editdiv" class="form-control" id="editdiv" value="{{ $inputs['editdiv'] }}">
                    <p class="form-control">{{ $t_edit->edit_name }}</p>
                </div>
                
                <div class="d-flex align-items-center">
                    <label for="datediv" class="form-label">日付区分</label>
                    <input type="hidden" name="datediv" class="form-control" id="datediv" value="{{ $inputs['datediv'] }}">
                    <p class="form-control">{{ $t_date->date_name }}</p>
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

