@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">

<!-- <br/> -->

    @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg') }}
        </p>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ route('UnNumber.edit_store') }}">
                @csrf
          
                <!-- <div class="d-flex align-items-center">
                    <h2 class="me-5">テスト確認画面</h2>
                    <p for="" class="me-4">テナントCD</p>
                    <p class="">{{ $inputs['TenantCode'] }} - {{ $inputs['TenantBranch'] }}</p>
                </div> -->
               
                <br/>
                <input type="hidden" id="TenantCode" name="TenantCode" value="{{ $inputs['TenantCode'] }}">
                <input type="hidden" id="TenantBranch" name="TenantBranch" value="{{ $inputs['TenantBranch'] }}">

                <div class="d-flex align-items-center">
                    <label for="numberdiv" class="form-label">採番区分</label>
                    <input type="hidden" name="numberdiv" class="form-control" id="numberdiv" value="{{ $inputs['numberdiv'] }}">
                    <p class="form-control">{{ $t_number->DivName }}</p>
                </div>

                <div class="d-flex align-items-center">
                    <label for="editdiv" class="form-label">編集区分</label>
                    <input type="hidden" name="editdiv" class="form-control" id="editdiv" value="{{ $inputs['editdiv'] }}">
                    <p class="form-control">{{ $t_edit->DivName }}</p>
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
                    <label for="lengs" class="form-label">有効桁数</label>
                    <input type="hidden" name="lengs" class="form-control" id="lengs" value="{{ $lengs }}">
                    <p class="form-control">{{ $lengs }}</p>
                </div>

                <div class="d-flex align-items-center">
                    <label for="initNumber" class="form-label">初期値</label>
                    <input type="hidden" name="initNumber" class="form-control" id="initNumber" value="{{ $inputs['initNumber'] }}">
                    <p class="form-control">{{ $inputs['initNumber'] }}</p>
                </div>
                
                <div class="d-flex align-items-center">
                    <label for="datediv" class="form-label">日付区分</label>
                    <input type="hidden" name="datediv" class="form-control" id="datediv" value="{{ $inputs['datediv'] }}">
                    <p class="form-control">{{ $t_date->DivName }}</p>
                </div>

                <div class="d-flex align-items-center">
                    <label for="numbercleardiv" class="form-label">クリア区分</label>
                    <input type="hidden" name="numbercleardiv" class="form-control" id="numbercleardiv" value="{{ $inputs['numbercleardiv'] }}">
                    <p class="form-control">{{ $t_numberclear->DivName }}</p>
                </div>

                <div class="align-items-center d-flex" id="symbol_wrap">
                    <label for="" class="form-label">採番後の番号目安</label>
                    <div class="">
                        <input type="text" name="check" class="form-control" id="check" value="{{ $inputs['check'] }}" disabled>
                        <!-- <div id="check" class="form-control" style="color:#999">採番後の番号が表示されます。</div> -->
                        <div id="err" class="ms-3" style="color:red"></div>
                    </div>
                </div>
                
                <div id="check" class="ms-4 p-2"></div>
                <div class="mt-5 d-flex">
                    <button type="button" onclick="history.back()" class="btn btn-primary me-4">戻 る</button>
                    <button type="submit" class="btn btn-primary" onclick="return checkSubmit()">確 定</button>
                </div>
            </form>
        
        </div>
    </div>
</div>

@endsection

