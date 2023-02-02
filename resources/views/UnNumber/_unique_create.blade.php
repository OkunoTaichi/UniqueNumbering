@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<h1>採番登録：採番区分の設定画面</h1>

    @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg') }}
        </p>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ route('UnNumber.unique_confirm') }}">
                @csrf

                <div class="d-flex align-items-center">
                    <label for="client_id" class="form-label">顧客番号</label>
                    <input type="hidden" name="client_id" class="form-control" id="client_id" value="{{ $client -> client_id }}">
                    <p class="form-control">{{ $client -> client_id }}</p>
                </div>
                <div class="d-flex align-items-center">
                    <label for="client_name" class="form-label">名前</label>
                    <input type="hidden" name="client_name" class="form-control" id="client_name" value="{{ $client -> client_name }}">
                    <p class="form-control">{{ $client -> client_name }}</p>
                </div>
                <div class="d-flex align-items-center">
                    <label for="tenant_id" class="form-label">利用会社</label>
                    <input type="hidden" name="tenant_id" class="form-control" id="tenant_id" value="{{ $client -> tenant_id }}">
                    <p class="form-control">{{ $client -> tenant_id }}</p>
                </div>

                <div class="d-flex align-items-center">
                    <label for="number_name" class="form-label">編集区分</label>
                    <select class="form-select" id="number_name" name="number_name">
                        @foreach ($edits as $edit)
                            <option value="{{ $edit->number_name }}">{{ $edit->number_name }}</option>
                        @endforeach
                    </select>
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

