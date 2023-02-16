@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<h1>登録画面</h1>

    @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg') }}
        </p>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
         <form method="POST" action="{{ route('UnNumber.confirm') }}">
                @csrf

                <div class="d-flex justify-content-xl-between">
                    <div class="d-flex align-items-center">
                        <label for="tenant_id" class="form-label align-middle">テナントコード</label>
                        <input type="text" name="tenant_id" class="form-control" id="tenant_id" value="22222222">
                        @if ($errors->has('tenant_id')) 
                        <div class="text-danger err_m">{{ $errors->first('tenant_id') }}</div>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="tenant_name" class="form-control" id="tenant_name" value="会社名A">
                <input type="hidden" name="tenantBranch_name" class="form-control" id="tenantBranch_name" value="施設名A">

                <div class="d-flex align-items-center">
                    <label for="number_name" class="form-label">採番区分名称</label>
                    <input type="hidden" name="number_id" class="form-control" id="number_id" value="1">
                    <input type="text" name="number_name" class="form-control" id="number_name" value="{{ old('number_name') }}">
                    @if ($errors->has('number_name')) 
                    <div class="text-danger err_m">{{ $errors->first('number_name') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="edit_id" class="form-label">編集区分</label>
                    <select class="form-select" id="edit_id" name="edit_id">
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
                    <label for="edit_length" class="form-label">有効桁数</label>
                    <input type="text" name="edit_length" class="form-control" id="edit_length" value="{{ old('edit_length') }}">
                    @if ($errors->has('edit_length')) 
                        <div class="text-danger err_m">{{ $errors->first('edit_length') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="date_id" class="form-label">日付区分</label>
                    <select class="form-select" id="date_id" name="date_id">
                        @foreach ($s_dates as $s_date)
                            <option value="{{ $s_date->id }}" 
                            @if(old('date_id') == $s_date->date_name)
                                selected
                            @endif
                            >{{ $s_date->date_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('date_id')) 
                        <div class="text-danger err_m">{{ $errors->first('date_id') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="symbol" class="form-label">記号</label>
                    <input type="text" name="symbol" class="form-control" id="symbol" value="{{ old('symbol') }}">
                    @if ($errors->has('symbol')) 
                        <div class="text-danger err_m">{{ $errors->first('symbol') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <label for="count_id" class="form-label">初期値</label>
                    <input type="text" name="count_id" class="form-control" id="count_id" value="{{ old('count_id') }}">
                    @if ($errors->has('count_id')) 
                        <div class="text-danger err_m">{{ $errors->first('count_id') }}</div>
                    @endif
                </div>

                <div class="mt-5 d-inline-block">
                    <a class="btn btn-secondary" href="{{ route('UnNumber.index') }}">
                        キャンセル
                    </a>
                    <button type="submit" class="btn btn-primary ms-4">
                        確 認
                    </button>
                </div>
            </form>
        
        </div>
    </div>
</div>

@endsection

