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
                    <div class="d-flex">
                        <div class="d-flex align-items-center">
                            <label for="number_name" class="form-label" style="width:140px">テナントコード</label>
                            <p class="form-control" style="width:100px">{{ $edit->TenantCode }}</p>
                        </div>
                        <div class="d-flex align-items-center" style="padding-left:20px">
                            <label for="number_name" class="form-label" style="width:140px">テナントブランチ</label>
                            <p class="form-control" style="width:100px">{{ $edit->TenantBranch }}</p>
                        </div>
                    </div>
                    <br/>
                    <div class="d-flex align-items-center">
                        <label for="number_name" class="form-label" style="width:140px">採番区分</label>
                        <p class="form-control">{{ $edit->numberdiv }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="reserve_id" class="form-label" style="width:140px">採番日付</label>
                        <p class="form-control">{{ $dateTime }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="reserve_id" class="form-label" style="width:140px">採番後の番号</label>
                        <p class="form-control">{{ $reserve_id }}</p>
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