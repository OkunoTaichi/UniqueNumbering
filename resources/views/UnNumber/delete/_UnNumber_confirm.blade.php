@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：登録確認画面')

@section('UnNumber.content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
         <form method="POST" action="{{ route('UnNumber.store') }}" onSubmit="return inputSubmit()">
                @csrf
    
                <div class="d-flex justify-content-xl-between">
                    <div class="d-flex align-items-center">
                        <label for="tenant_id" class="form-label align-middle">テナントコード</label>
                        <input type="hidden" name="tenant_id" class="form-control" id="tenant_id" value="{{ $inputs['tenant_id'] }}">
                        <p class="form-control">{{ $inputs['tenant_id'] }}</p>
                    </div>
                </div>
                <input type="hidden" name="tenant_name" class="form-control" id="tenant_name" value="会社名A">
                <input type="hidden" name="tenantBranch_name" class="form-control" id="tenantBranch_name" value="施設名A">

                <div class="d-flex align-items-center">
                    <label for="number_name" class="form-label">採番区分</label>
                    <input type="hidden" name="number_id" class="form-control" id="number_id" value="{{ $inputs['number_id'] }}">
                    <input type="hidden" name="number_name" class="form-control" id="number_name" value="{{ $inputs['number_name'] }}">
                    <p class="form-control">{{ $inputs['number_name'] }}</p>
                </div>

                <div class="d-flex align-items-center">
                    <label for="edit_id" class="form-label">編集区分 : ID</label>
                    <input type="hidden" name="edit_id" class="form-control" id="edit_id" value="{{ $inputs['edit_id'] }}">
                    <p class="form-control">{{ $t_edit }} : {{ $inputs['edit_id'] }}</p>

                    <input type="hidden" name="edit_name" class="form-control" id="edit_name" value="{{ $t_edit }}">
                </div>

                <div class="d-flex align-items-center">
                    <label for="edit_length" class="form-label">有効桁数</label>
                    <input type="hidden" name="edit_length" class="form-control" id="edit_length" value="{{ $inputs['edit_length'] }}">
                    <p class="form-control">{{ $inputs['edit_length'] }}</p>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <label for="date_id" class="form-label">日付区分 : ID</label>
                    <input type="hidden" name="date_id" class="form-control" id="date_id" value="{{ $inputs['date_id'] }}">
                    <input type="hidden" name="date_name" class="form-control" id="date_name" value="{{ $t_date }}">  
                    <p class="form-control">{{ $t_date }} : {{ $inputs['date_id'] }}</p>
                </div>

                <div class="d-flex align-items-center">
                    <label for="symbol" class="form-label">記号</label>
                    <input type="hidden" name="symbol" class="form-control" id="symbol" value="{{ $inputs['symbol'] }}">
                    <p class="form-control">{{ $inputs['symbol'] }}</p>
                </div>

                <div class="d-flex align-items-center">
                    <label for="count_id" class="form-label">初期値</label>
                    <input type="hidden" name="count_id" class="form-control" id="count_id" value="{{ $inputs['count_id'] }}">
                    <p class="form-control">{{ $inputs['count_id'] }}</p>
                </div>
                

                

                

               

                <div class="mt-5 d-inline-block">
                    <button class="btn btn-secondary" onClick="history.back();">
                        キャンセル
                    </button>
                    <button type="submit" class="btn btn-primary ms-4">
                        確 定
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
