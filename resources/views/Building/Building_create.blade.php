@extends('Building.Building_layouts.Building_layout')
@section('Building.Building_layouts.Building_layout.title', '採番マスタ：一覧表示画面')

@section('Building.content')


<div class="container">
  
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="person_wrap">
        @include('Building.Building_layouts.Building_link')<!-- 新規登録とかのボタン表示 -->  
        <div class="form_parson">

        @if(session('err_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('err_msg') }}</p>
        @endif
        @if(session('successe_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('successe_msg') }}</p>
        @endif

          <form name="BuildingForm" action="{{ route('Building.Building_store') }}" method="post">
            @csrf

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">棟コード</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="BuildingCode" name="BuildingCode" value="{{ $building->BuildingCode }}" disabled>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="BuildingCode" name="BuildingCode" value="{{ $building->BuildingCode }}" readonly maxlength="3" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="BuildingCode" class="enterTab" name="BuildingCode" value="{{ $building['BuildingCode'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="3" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="BuildingCode" class="enterTab" name="BuildingCode" value="{{ old('BuildingCode') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="3" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="BuildingCode" class="enterTab" name="BuildingCode" value="{{ old('BuildingCode') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="3" required>
              @endif

              @if ($errors->has('BuildingCode')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('BuildingCode') }}</div>
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">棟名称</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="BuildingName" name="BuildingName" value="{{ $building->BuildingName }}" disabled maxlength="10" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="BuildingName" name="BuildingName" value="{{ $building->BuildingName }}" maxlength="10" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="BuildingName" class="enterTab" name="BuildingName" value="{{ $building['BuildingName'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="10" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="BuildingName" class="enterTab" name="BuildingName" value="{{ old('BuildingName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="10" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="BuildingName" class="enterTab" name="BuildingName" value="{{ old('BuildingName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="10" required>
              @endif

              @if ($errors->has('BuildingName')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('BuildingName') }}</div>
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">棟略称</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="BuildingAbName" name="BuildingAbName" value="{{ $building->BuildingAbName }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="BuildingAbName" name="BuildingAbName" value="{{ $building->BuildingAbName }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="BuildingAbName" class="enterTab" name="BuildingAbName" value="{{ $building['BuildingAbName'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="BuildingAbName" class="enterTab" name="BuildingAbName" value="{{ old('BuildingAbName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="BuildingAbName" class="enterTab" name="BuildingAbName" value="{{ old('BuildingAbName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
              @endif

              @if ($errors->has('BuildingAbName')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('BuildingAbName') }}</div>
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">表示順</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="DisplayOrder" name="DisplayOrder" value="{{ $building->DisplayOrder }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="DisplayOrder" name="DisplayOrder" value="{{ $building->DisplayOrder }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="DisplayOrder" class="enterTab" name="DisplayOrder" value="{{ $building['DisplayOrder'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="DisplayOrder" class="enterTab" name="DisplayOrder" value="{{ old('DisplayOrder') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="DisplayOrder" class="enterTab" name="DisplayOrder" value="{{ old('DisplayOrder') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
              @endif

              @if ($errors->has('DisplayOrder')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('DisplayOrder') }}</div>
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">非表示</label>
              <div class="disabled">
                @if(isset($route_flag))

                  @if($route_flag === 1)<!-- 詳細モード -->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($building !== null){{ $building->Hidden === 1 ? 'checked ' : '' }}@endif disabled>
                  @elseif($route_flag === 2)<!-- 編集 -->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($building !== null){{ $building->Hidden === 1 ? 'checked ' : '' }}@endif>
                  @elseif($route_flag === 3)<!-- コピーモード -->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($building !== null){{ $building['Hidden'] === 1 ? 'checked ' : '' }}@endif>
                  @else<!-- 新規作成モード （保険）-->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if(old("Hidden") !== null) checked @endif>
                  @endif

                @else<!-- 新規作成モード -->
                <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if(old("Hidden") !== null) checked @endif> 
                @endif

                @if ($errors->has('Hidden')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('Hidden') }}</div>
                @endif
              </div>
            </div>

            


            
            

            @if(isset($routeFlag))

              @if($routeFlag === 1)<!-- 詳細モードは確定なし -->
                <button type="button" class="btn btn-primary" tabindex="" onclick="history.back()">戻 る</button>
              @else
              <div class="d-flex">
                <button type="button" class="btn btn-primary back_btn" tabindex="" onclick="history.back()">戻 る</button>
                <button type="button" id="enter" class="btn btn-primary enterTab" tabindex="" onclick="createAlert()">確 定</button>
              </div>
              @endif

            @else
              <div class="d-flex">
                <button type="button" class="btn btn-primary back_btn" tabindex="" onclick="history.back()">戻 る</button>
                <button type="button" id="enter" class="btn btn-primary enterTab" tabindex="" onclick="createAlert()">確 定</button>
              </div>
            @endif
            
          </form>
        </div>

      </div>
    </div>

  </div>

</div>

<script>
  // 全角->半角変換(日本語不可)
  function ztoh(te) {
    var ts = te.value;
    // 英数字が全角なら半角に変換
    ts = ts.replace( /[０-９ Ａ-Ｚ ａ-ｚ ]/g, function(es) {
        return String.fromCharCode(es.charCodeAt(0) - 65248);
    });
    // 半角英数字記号以外は消去
    // while(ts.match(/[^A-Z^a-z\d\-\!"#$%&'()*+-.,\/:;<=>?@[\]^_`{|}~]/))
    // {
    //     ts=ts.replace(/[^A-Z^a-z\d\-\!"#$%&'()*+-.,\/:;<=>?@[\]^_`{|}~]/,"");
    // }
    te.value = ts;
  }
  
  // 半角->全角変換
  function htoz(te) {
   var ts = te.value;
   ts = ts.replace( /[0-9A-Za-z]/g, function(es) {
      return String.fromCharCode(es.charCodeAt(0) + 65248);
   });
   te.value = ts;
  }
</script>

@endsection