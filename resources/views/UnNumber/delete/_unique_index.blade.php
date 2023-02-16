@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<h1>採番登録：テナントコード、ユーザー設定画面</h1>

    @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg') }}
        </p>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ route('UnNumber.unique_create') }}">
                @csrf

                <div class="d-flex align-items-center">
                    <label for="SignIn" class="form-label">ユーザー登録</label>
                    <input type="text" name="SignIn" class="form-control" id="SignIn" value="{{ old('SignIn') }}">
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

