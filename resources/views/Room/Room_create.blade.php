@extends('Room.Room_layouts.Room_layout')
@section('Room.Room_layouts.Room_layout.title', '採番マスタ：一覧表示画面')

@section('Room.content')


<div class="container">
  
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="person_wrap">
        @include('Room.Room_layouts.Room_link')<!-- 新規登録とかのボタン表示 -->  
        <div class="form_parson">

        @if(session('err_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('err_msg') }}</p>
        @endif
        @if(session('successe_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('successe_msg') }}</p>
        @endif

          <form name="RoomForm" action="{{ route('Room.Room_store') }}" method="post">
            @csrf

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">部屋番号</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="RoomNo" name="RoomNo" value="{{ $room->RoomNo }}" disabled>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="RoomNo" name="RoomNo" value="{{ $room->RoomNo }}" readonly maxlength="10" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="RoomNo" class="enterTab" name="RoomNo" value="{{ $room['RoomNo'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="10" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="RoomNo" class="enterTab" name="RoomNo" value="{{ old('RoomNo') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="10" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="RoomNo" class="enterTab" name="RoomNo" value="{{ old('RoomNo') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="10" required>
              @endif

              @if ($errors->has('RoomNo')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('RoomNo') }}</div>
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">棟コード</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <select class="form-select enterTab" id="BuildingCode" class="enterTab" name="BuildingCode" disabled>
                  <option value="{{ $building->BuildingCode }}">{{ $building->BuildingCode }} : {{ $building->BuildingName }}</option>   
                </select>

                @elseif($route_flag === 2)<!-- 編集 -->
                <select class="form-select enterTab" id="BuildingCode" class="enterTab" name="BuildingCode">
                  <option value="{{ $building->BuildingCode }}">{{ $building->BuildingCode }} : {{ $building->BuildingName }}</option>   
                  @foreach ($buildings as $building)
                  <option value="{{ $building->BuildingCode }}">{{ $building->BuildingCode }} : {{ $building->BuildingName }}</option>   
                  @endforeach
                </select>

                @elseif($route_flag === 3)<!-- コピーモード -->
                <select class="form-select enterTab" id="BuildingCode" class="enterTab" name="BuildingCode">
                  <option value="{{ $room['BuildingCode'] }}">{{ $room['BuildingCode'] }} : {{ $room['BuildingName'] }}</option>   
                  @foreach ($buildings as $building)
                  <option value="{{ $building->BuildingCode }}">{{ $building->BuildingCode }} : {{ $building->BuildingName }}</option>   
                  @endforeach
                </select>

                @else<!-- 新規作成モード （保険）-->
                <select class="form-select enterTab" id="BuildingCode" class="enterTab" name="BuildingCode"> 
                  @foreach ($buildings as $building)
                  <option value="{{ $building->BuildingCode }}">{{ $building->BuildingCode }} : {{ $building->BuildingName }}</option>    
                  @endforeach
                </select>
                @endif
                
              @else
                <!-- 新規作成モード -->
                <select class="form-select enterTab" id="BuildingCode" class="enterTab" name="BuildingCode">  
                @foreach ($buildings as $building)
                  <option value="{{ $building->BuildingCode }}">{{ $building->BuildingCode }} : {{ $building->BuildingName }}</option>    
                @endforeach
                </select>
              @endif

              @if ($errors->has('BuildingCode')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('BuildingCode') }}</div>
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">部屋タイプ</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="RoomTypeCode" name="RoomTypeCode" value="{{ $room->RoomTypeCode }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="RoomTypeCode" name="RoomTypeCode" value="{{ $room->RoomTypeCode }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="RoomTypeCode" class="enterTab" name="RoomTypeCode" value="{{ $room['RoomTypeCode'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="RoomTypeCode" class="enterTab" name="RoomTypeCode" value="{{ old('RoomTypeCode') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="BuildingAbName" class="enterTab" name="BuildingAbName" value="{{ old('BuildingAbName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
              @endif

              @if ($errors->has('BuildingAbName')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('BuildingAbName') }}</div>
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">部屋名称</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="RoomName" name="RoomName" value="{{ $room->RoomName }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="RoomName" name="RoomName" value="{{ $room->RoomName }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="RoomName" class="enterTab" name="RoomName" value="{{ $room['RoomName'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="RoomName" class="enterTab" name="RoomName" value="{{ old('RoomName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="RoomName" class="enterTab" name="RoomName" value="{{ old('RoomName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
              @endif

              @if ($errors->has('RoomName')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('RoomName') }}</div>
              @endif
            </div>


            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">部屋略称</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="RoomAbName" name="RoomAbName" value="{{ $room->RoomAbName }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="RoomAbName" name="RoomAbName" value="{{ $room->RoomAbName }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="RoomAbName" class="enterTab" name="RoomAbName" value="{{ $room['RoomAbName'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="RoomAbName" class="enterTab" name="RoomAbName" value="{{ old('RoomAbName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="RoomAbName" class="enterTab" name="RoomAbName" value="{{ old('RoomAbName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
              @endif

              @if ($errors->has('RoomAbName')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('RoomAbName') }}</div>
              @endif
            </div>


            <div class="d-flex input_parson_wrap" style="align-items: center;">
              <label for="" class="form-label">定員</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="CapacityMin" name="CapacityMin" value="{{ $room->CapacityMin }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="CapacityMin" name="CapacityMin" value="{{ $room->CapacityMin }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="CapacityMin" class="enterTab" name="CapacityMin" value="{{ $room['CapacityMin'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="CapacityMin" class="enterTab" name="CapacityMin" value="{{ old('CapacityMin') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="CapacityMin" class="enterTab" name="CapacityMin" value="{{ old('CapacityMin') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
              @endif

              <p style="align-items: center; margin: 0 10px;"> ～ </p>
             
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="CapacityMax" name="CapacityMax" value="{{ $room->CapacityMax }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="CapacityMax" name="CapacityMax" value="{{ $room->CapacityMax }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="CapacityMax" class="enterTab" name="CapacityMax" value="{{ $room['CapacityMax'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="CapacityMax" class="enterTab" name="CapacityMax" value="{{ old('CapacityMax') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="CapacityMax" class="enterTab" name="CapacityMax" value="{{ old('CapacityMax') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
              @endif

              @if ($errors->has('CapacityMax')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('CapacityMax') }}</div>
              @endif
            </div>
            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">フロア</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="Floor" name="Floor" value="{{ $room->Floor }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="Floor" name="Floor" value="{{ $room->Floor }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="Floor" class="enterTab" name="Floor" value="{{ $room['Floor'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="Floor" class="enterTab" name="Floor" value="{{ old('Floor') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="Floor" class="enterTab" name="Floor" value="{{ old('Floor') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
              @endif

              @if ($errors->has('Floor')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('Floor') }}</div>
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">表示順</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="DisplayOrder" name="DisplayOrder" value="{{ $room->DisplayOrder }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="DisplayOrder" name="DisplayOrder" value="{{ $room->DisplayOrder }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="DisplayOrder" class="enterTab" name="DisplayOrder" value="{{ $room['DisplayOrder'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
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
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($room !== null){{ $room->Hidden === 1 ? 'checked ' : '' }}@endif disabled>
                  @elseif($route_flag === 2)<!-- 編集 -->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($room !== null){{ $room->Hidden === 1 ? 'checked ' : '' }}@endif>
                  @elseif($route_flag === 3)<!-- コピーモード -->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($room !== null){{ $room['Hidden'] === 1 ? 'checked ' : '' }}@endif>
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

            @if(isset($route_flag))

              @if($route_flag === 1)<!-- 詳細モードは確定なし -->
                <!-- <button type="button" class="btn btn-primary" tabindex="" onclick="history.back()">戻 る</button> -->
                <button type="button" class="btn me-4 btn-primary"><a style="color:#fff; text-decoration:none;" href="{{ route('Room.Room_index') }}">戻 る</a></button>
              @else
              <div class="d-flex">
                <!-- <button type="button" class="btn btn-primary back_btn" tabindex="" onclick="history.back()">戻 る</button> -->
                <button type="button" class="btn me-4 btn-primary"><a style="color:#fff; text-decoration:none;" href="{{ route('Room.Room_index') }}">戻 る</a></button>
                <button type="button" id="enter" class="btn btn-primary enterTab" tabindex="" onclick="createAlertRoom()">確 定</button>
              </div>
              @endif

            @else
              <div class="d-flex">
                <!-- <button type="button" class="btn btn-primary back_btn" tabindex="" onclick="history.back()">戻 る</button> -->
                <button type="button" class="btn me-4 btn-primary"><a style="color:#fff; text-decoration:none;" href="{{ route('Room.Room_index') }}">戻 る</a></button>
                <button type="button" id="enter" class="btn btn-primary enterTab" tabindex="" onclick="createAlertRoom()">確 定</button>
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