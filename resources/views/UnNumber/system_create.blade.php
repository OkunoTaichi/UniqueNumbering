@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<h2>採番登録：確認画面</h2><br/>

<h3 class="text-danger">以下の内容で登録しました。</h3><br/>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="wrap d-flex align-items-center">

                <div class="main">
                    <div class="d-flex align-items-center">
                        <label for="number_name" class="form-label">予約項目</label>
                        <p class="form-control">{{ $edits -> NumberDivs -> number_name }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="reserve_id" class="form-label">採番後の番号</label>
                        <p class="form-control">{{ $reserve_id }}</p>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <label for="client_id" class="form-label">ユーザーの名前</label>
                        <p class="form-control">{{ $client -> client_name }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="client_name" class="form-label">ユーザーID</label>
                        <p class="form-control">{{ $client -> client_id }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="tenant_id" class="form-label">会社＋施設コード</label>
                        <p class="form-control">{{ $client -> tenant_id }}</p>
                    </div>
                </div>

            </div>
            
            <div class="mt-5 d-inline-block">
                <a href="{{ route('UnNumber.system_index') }}" class="btn btn-primary me-4">採番処理画面へ戻る</a>
              
            </div>
       
        </div>
    </div>
</div>

@endsection