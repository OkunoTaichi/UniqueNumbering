@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<h1>採番処理画面</h1></br>


    @if(session('err_msg'))
        <p class="text-danger">
            {{ session('err_msg') }}
        </p>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ route('UnNumber.system_create') }}" onSubmit="return inputSubmit()">
                @csrf

                <input type="hidden" id="TenantCode" name="TenantCode" value="{{ $tenantCode }}">
                <input type="hidden" id="TenantBranch" name="TenantBranch" value="{{ $tenantBranch }}">

                <div class="d-flex align-items-center">
                    <label for="date" class="form-label" style="width:140px">日時を入力</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div></br>

                <!-- 採番区分ごとにボタン配置 -->
                <div class="d-flex align-items-center">
                    <label for="number_id" class="form-label" style="width:140px">採番区分選択</label>
                    <select class="form-select" id="number_id" name="number_id">
                        @foreach ($M_Divisions as $M_Division)
                            <option value="{{ $M_Division->DivNo }}">{{ $M_Division->DivNo }} : {{ $M_Division->DivName }}</option>
                        @endforeach
                    </select>
                   
                </div>
                </br>
                <div class="col-sm-auto">
                    <button type="submit" class="btn btn-primary ">採番実行</button>
                </div>
            
              
            </form>
        
        </div>
    </div>
</div>
<script type="text/javascript">
    //今日の日時を表示
        window.onload = function () {
            //今日の日時を表示
            var date = new Date()
            var year = date.getFullYear()
            var month = date.getMonth() + 1
            var day = date.getDate()
          
            var toTwoDigits = function (num, digit) {
              num += ''
              if (num.length < digit) {
                num = '0' + num
              }
              return num
            }
            
            var yyyy = toTwoDigits(year, 4)
            var mm = toTwoDigits(month, 2)
            var dd = toTwoDigits(day, 2)
            var ymd = yyyy + "-" + mm + "-" + dd;
            
            document.getElementById("date").value = ymd;
        }
</script>

@endsection

