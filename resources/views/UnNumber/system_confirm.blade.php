@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<h1>採番登録：確認画面</h1>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="">
                @csrf

                <div class="wrap d-flex align-items-center">

                    <div class="main">
                        <div class="d-flex align-items-center">
                            <label for="number_name" class="form-label">予約項目</label>
                            <input type="hidden" name="number_name" class="form-control" id="number_name" value="{{ $edits -> NumberDivs -> number_name }}">
                            <p class="form-control">{{ $edits -> NumberDivs -> number_name }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="reserve_id" class="form-label">採番後の番号</label>
                            <input type="hidden" name="reserve_id" class="form-control" id="reserve_id" value="{{ $reserve_id }}">
                            <p class="form-control">{{ $reserve_id }}</p>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <label for="client_id" class="form-label">ユーザーID:</label>
                            <input type="hidden" name="client_id" class="form-control" id="client_id" value="{{ $client -> client_name }}">
                            <p class="form-control">{{ $client -> client_name }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="client_name" class="form-label">ユーザーの名前</label>
                            <input type="hidden" name="client_name" class="form-control" id="client_name" value="{{ $client -> client_id }}">
                            <p class="form-control">{{ $client -> client_id }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="tenant_id" class="form-label">会社＋施設コード</label>
                            <input type="hidden" name="tenant_id" class="form-control" id="tenant_id" value="{{ $client -> tenant_id }}">
                            <p class="form-control">{{ $client -> tenant_id }}</p>
                        </div>
                    </div>
    
                </div>
                
                <div class="mt-5 d-inline-block">
                    <button type="submit" class="btn btn-primary me-4">
                        確 定
                    </button>
                </div>
            </form>
        
        </div>
    </div>
</div>

@endsection


