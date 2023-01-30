@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：新規登録画面')

@section('UnNumber.content')
<div class="container">
<h1>採番処理画面</h1>

    @if ($errors->has('SignIn')) 
        <div class="text-danger err_m">{{ $errors->first('SignIn') }}</div>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="{{ route('UnNumber.system_create') }}" onSubmit="return inputSubmit()">
                @csrf

                <div class="d-flex align-items-center">
                    <label for="SignIn" class="form-label">ユーザー登録</label>
                    <input type="text" name="SignIn" class="form-control" id="SignIn" value="{{ old('SignIn') }}">
                </div>
                <div class="d-flex align-items-center">
                    <label for="date" class="form-label">日時を入力</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div>

                <!-- 採番区分ごとにボタン配置 -->
            
                <div class="mt-5 d-inline-block">
                    <button type="submit" class="btn btn-primary ms-4" name="number_id" id="1" value="1">
                        予約No
                    </button>
                    <button type="submit" class="btn btn-primary ms-4" name="number_id" id="2" value="2">
                        利用No
                    </button>
                    <button type="submit" class="btn btn-primary ms-4" name="number_id" id="3" value="3">
                        利用個別No
                    </button>
                    <button type="submit" class="btn btn-primary ms-4" name="number_id" id="4" value="4">
                        利用部屋No
                    </button>
                    <button type="submit" class="btn btn-primary ms-4" name="number_id" id="5" value="5">
                        伝票No
                    </button>
                    <button type="submit" class="btn btn-primary ms-4" name="number_id" id="6" value="6">
                        予約金No
                    </button>
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

