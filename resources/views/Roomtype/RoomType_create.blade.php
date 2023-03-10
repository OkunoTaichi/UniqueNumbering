@extends('RoomType.RoomType_layouts.RoomType_layout')
@section('RoomType.RoomType_layouts.RoomType_layout.title', '採番マスタ：一覧表示画面')

@section('RoomType.content')


<div class="container">
  
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="person_wrap">
        @include('RoomType.RoomType_layouts.RoomType_link')<!-- 新規登録とかのボタン表示 -->  
        <div class="form_parson">

        @if(session('err_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('err_msg') }}</p>
        @endif
        @if(session('successe_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('successe_msg') }}</p>
        @endif

          <form name="RoomTypeForm" action="{{ route('RoomType.RoomType_store') }}" method="post">
            @csrf

            <div class="d-flex room_type_wrap">
              <label for="" class="form-label">タイプコード</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="RoomTypeCode" name="RoomTypeCode" value="{{ $room_type->RoomTypeCode }}" disabled  required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="RoomTypeCode" name="RoomTypeCode" value="{{ $room_type->RoomTypeCode }}" maxlength="4" required>
                @elseif($route_flag === 3)<!-- コピーペーストモード -->
                <input type="text" id="RoomTypeCode" class="enterTab" name="RoomTypeCode" value="{{ $room_type['RoomTypeCode'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="4" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="RoomTypeCode" class="enterTab" name="RoomTypeCode" value="{{ old('RoomTypeCode') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="4" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="RoomTypeCode" class="enterTab" name="RoomTypeCode" value="{{ old('RoomTypeCode') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="4" required>
              @endif

              @if ($errors->has('RoomTypeCode')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('RoomTypeCode') }}</div>
              @endif
             
            </div>

            <div class="d-flex room_type_wrap">
              <label for="" class="form-label">名称</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="RoomTypeName" name="RoomTypeName" value="{{ $room_type->RoomTypeName }}" disabled maxlength="15" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="RoomTypeName" name="RoomTypeName" value="{{ $room_type->RoomTypeName }}" maxlength="15" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="RoomTypeName" class="enterTab" name="RoomTypeName" value="{{ $room_type['RoomTypeName'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="15" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="RoomTypeName" class="enterTab" name="RoomTypeName" value="{{ old('RoomTypeName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="15" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="RoomTypeName" class="enterTab" name="RoomTypeName" value="{{ old('RoomTypeName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="15" required>
              @endif

              @if ($errors->has('RoomTypeName')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('RoomTypeName') }}</div>
              @endif
            </div>


            <div class="d-flex room_type_wrap">
              <label for="" class="form-label">略称</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="RoomTypeAbName" name="RoomTypeAbName" value="{{ $room_type->RoomTypeAbName }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="RoomTypeAbName" name="RoomTypeAbName" value="{{ $room_type->RoomTypeAbName }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="RoomTypeAbName" class="enterTab" name="RoomTypeAbName" value="{{ $room_type['RoomTypeAbName'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="RoomTypeAbName" class="enterTab" name="RoomTypeAbName" value="{{ old('RoomTypeAbName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="RoomTypeAbName" class="enterTab" name="RoomTypeAbName" value="{{ old('RoomTypeAbName') }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
              @endif

              @if ($errors->has('RoomTypeAbName')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('RoomTypeAbName') }}</div>
              @endif
            </div>

            <div class="d-flex room_type_wrap">
              <label for="" class="form-label">部屋種別区分</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <select class="form-select enterTab" id="RoomTypeDiv" class="enterTab" name="RoomTypeDiv" disabled>
                  <option value="{{ $room_type_div_select->DivNo }}">{{ $room_type_div_select->DivNo }} : {{ $room_type_div_select->DivName }}</option>   
                </select>

                @elseif($route_flag === 2)<!-- 編集 -->
                <select class="form-select enterTab" id="RoomTypeDiv" class="enterTab" name="RoomTypeDiv">
                  <option value="{{ $room_type_div_select->DivNo }}">{{ $room_type_div_select->DivNo }} : {{ $room_type_div_select->DivName }}</option>     
                  @foreach ($room_type_divs as $room_type_div)
                  <option value="{{ $room_type_div->DivNo }}">{{ $room_type_div->DivNo }} : {{ $room_type_div->DivName }}</option>   
                  @endforeach
                </select>

                @elseif($route_flag === 3)<!-- コピーモード -->
                <select class="form-select enterTab" id="RoomTypeDiv" class="enterTab" name="RoomTypeDiv">
                  <option value="{{ $room_type['RoomTypeDiv'] }}">{{ $room_type['RoomTypeDiv'] }} : {{ $room_type['RoomTypeDivName'] }}</option>     
                  @foreach ($room_type_divs as $room_type_div)
                  <option value="{{ $room_type_div->DivNo }}">{{ $room_type_div->DivNo }} : {{ $room_type_div->DivName }}</option>   
                  @endforeach
                </select>

                @else<!-- 新規作成モード （保険）-->
                <select class="form-select enterTab" id="RoomTypeDiv" class="enterTab" name="RoomTypeDiv" oninput="RealTypeDisabled();"> 
                  @foreach ($room_type_divs as $room_type_div)
                  <option value="{{ $room_type_div->DivNo }}">{{ $room_type_div->DivNo }} : {{ $room_type_div->DivName }}</option>   
                  @endforeach
                </select>
                @endif
                
              @else
                <!-- 新規作成モード -->
                <select class="form-select enterTab" id="RoomTypeDiv" class="enterTab" name="RoomTypeDiv">  
                  @foreach ($room_type_divs as $room_type_div)
                  <option value="{{ $room_type_div->DivNo }}">{{ $room_type_div->DivNo }} : {{ $room_type_div->DivName }}</option>   
                  @endforeach
                </select>
              @endif

              @if ($errors->has('RoomTypeDiv')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('RoomTypeDiv') }}</div>
              @endif
            </div>


            <div class="d-flex room_type_wrap">
              <label for="" class="form-label">稼働計上区分</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <select class="form-select enterTab" id="OperationDiv" class="enterTab" name="OperationDiv" disabled>
                  <option value="{{ $operation_div_select->DivNo }}">{{ $operation_div_select->DivNo }} : {{ $operation_div_select->DivName }}</option>   
                </select>

                @elseif($route_flag === 2)<!-- 編集 -->
                <select class="form-select enterTab" id="OperationDiv" class="enterTab" name="OperationDiv">
                  <option value="{{ $operation_div_select->DivNo }}">{{ $operation_div_select->DivNo }} : {{ $operation_div_select->DivName }}</option>   
                  @foreach ($operation_divs as $operation_div)
                  <option value="{{ $operation_div->DivNo }}">{{ $operation_div->DivNo }} : {{ $operation_div->DivName }}</option>   
                  @endforeach
                </select>

                @elseif($route_flag === 3)<!-- コピーモード -->
                <select class="form-select enterTab" id="OperationDiv" class="enterTab" name="OperationDiv">
                  <option value="{{ $room_type['OperationDiv'] }}">{{ $room_type['OperationDiv'] }} : {{ $room_type['OperationDivName'] }}</option>      
                  @foreach ($operation_divs as $operation_div)
                  <option value="{{ $operation_div->DivNo }}">{{ $operation_div->DivNo }} : {{ $operation_div->DivName }}</option>   
                  @endforeach
                </select>

                @else<!-- 新規作成モード （保険）-->
                <select class="form-select enterTab" id="OperationDiv" class="enterTab" name="OperationDiv"> 
                  @foreach ($operation_divs as $operation_div)
                  <option value="{{ $operation_div->DivNo }}">{{ $operation_div->DivNo }} : {{ $operation_div->DivName }}</option>   
                  @endforeach
                </select>
                @endif
                
              @else
                <!-- 新規作成モード -->
                <select class="form-select enterTab" id="OperationDiv" class="enterTab" name="OperationDiv">  
                  @foreach ($operation_divs as $operation_div)
                  <option value="{{ $operation_div->DivNo }}">{{ $operation_div->DivNo }} : {{ $operation_div->DivName }}</option>   
                  @endforeach
                </select>
              @endif

              @if ($errors->has('OperationDiv')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('OperationDiv') }}</div>
              @endif
            </div>





            <div class="d-flex room_type_wrap" style="align-items: center;">
              <label for="" class="form-label">残室表示区分</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <select class="form-select enterTab" id="RemainingRoomDiv" class="enterTab" name="RemainingRoomDiv" disabled>
                  <option value="{{ $remaining_room_div_select->DivNo }}">{{ $remaining_room_div_select->DivNo }} : {{ $remaining_room_div_select->DivName }}</option>    
                </select>

                @elseif($route_flag === 2)<!-- 編集 -->
                <select class="form-select enterTab" id="RemainingRoomDiv" class="enterTab" name="RemainingRoomDiv">
                  <option value="{{ $remaining_room_div_select->DivNo }}">{{ $remaining_room_div_select->DivNo }} : {{ $remaining_room_div_select->DivName }}</option>   
                  @foreach ($remaining_room_divs as $remaining_room_div)
                  <option value="{{ $remaining_room_div->DivNo }}">{{ $remaining_room_div->DivNo }} : {{ $remaining_room_div->DivName }}</option>   
                  @endforeach
                </select>

                @elseif($route_flag === 3)<!-- コピーモード -->
                <select class="form-select enterTab" id="RemainingRoomDiv" class="enterTab" name="RemainingRoomDiv">
                  <option value="{{ $room_type['RemainingRoomDiv'] }}">{{ $room_type['RemainingRoomDiv'] }} : {{ $room_type['RemainingRoomDivName'] }}</option>         
                  @foreach ($remaining_room_divs as $remaining_room_div)
                  <option value="{{ $remaining_room_div->DivNo }}">{{ $remaining_room_div->DivNo }} : {{ $remaining_room_div->DivName }}</option>   
                  @endforeach
                </select>

                @else<!-- 新規作成モード （保険）-->
                <select class="form-select enterTab" id="RemainingRoomDiv" class="enterTab" name="RemainingRoomDiv"> 
                  @foreach ($remaining_room_divs as $remaining_room_div)
                  <option value="{{ $remaining_room_div->DivNo }}">{{ $remaining_room_div->DivNo }} : {{ $remaining_room_div->DivName }}</option>   
                  @endforeach
                </select>
                @endif
                
              @else
                <!-- 新規作成モード -->
                <select class="form-select enterTab" id="RemainingRoomDiv" class="enterTab" name="RemainingRoomDiv">  
                  @foreach ($remaining_room_divs as $remaining_room_div)
                  <option value="{{ $remaining_room_div->DivNo }}">{{ $remaining_room_div->DivNo }} : {{ $remaining_room_div->DivName }}</option>   
                  @endforeach
                </select>
              @endif

              @if ($errors->has('RemainingRoomDiv')) <!-- バリデーションメッセージ -->
                <div class="text-danger err_m">&lowast; {{ $errors->first('RemainingRoomDiv') }}</div>
              @endif
            </div>



            <div class="d-flex room_type_wrap">
              <label for="" class="form-label">実タイプコード</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <select class="form-select enterTab" id="RealTypeCode" name="RealTypeCode" disabled> 
                  <option>{{ isset($real_type_select->RoomTypeCode) ? $real_type_select->RoomTypeCode .' : '. $real_type_select->RoomTypeName : '-' }}</option>   
                </select>

                @elseif($route_flag === 2)<!-- 編集 -->
                <select class="form-select enterTab" id="RealTypeCode" name="RealTypeCode">
                  <option value="{{ isset($real_type_select->RoomTypeCode) ? $real_type_select->RoomTypeCode : '' }}">{{ isset($real_type_select->RoomTypeCode) ? $real_type_select->RoomTypeCode .' : '. $real_type_select->RoomTypeName : '-' }}</option>    
                  <option value="">-</option> 
                  @foreach ($real_type_codes as $real_type_code)
                  <option value="{{ $real_type_code->RoomTypeCode }}">{{ $real_type_code->RoomTypeCode }} : {{ $real_type_code->RoomTypeName }}</option>   
                  @endforeach
                </select>

                @elseif($route_flag === 3)<!-- コピーモード -->
                <select class="form-select enterTab" id="RealTypeCode" name="RealTypeCode">
                  <option value="{{ isset($room_type['RealTypeCode']) ? $room_type['RealTypeCode'] : '' }}">{{ isset($room_type['RealTypeCode']) ? $room_type['RealTypeCode'] .' : '. $room_type['RealTypeName'] : '-' }}</option>       
                  <option value="">-</option> 
                  @foreach ($real_type_codes as $real_type_code)
                  <option value="{{ $real_type_code->RoomTypeCode }}">{{ $real_type_code->RoomTypeCode }} : {{ $real_type_code->RoomTypeName }}</option>   
                  @endforeach
                </select>

                @else<!-- 新規作成モード （保険）-->
                <select class="form-select enterTab disabled_real" id="RealTypeCode" name="RealTypeCode">
                  <option value=""></option>
                  @foreach ($real_type_codes as $real_type_code)
                  <option value="{{ $real_type_code->RoomTypeCode }}" >{{ $real_type_code->RoomTypeCode }} : {{ $real_type_code->RoomTypeName }}</option>   
                  @endforeach
                </select>
                @endif

              @else
                <!-- 新規作成モード -->
                <select class="form-select enterTab" id="RealTypeCode" class="enterTab" name="RealTypeCode">  
                  <option value=""></option>
                  @foreach ($real_type_codes as $real_type_code)
                  <option value="{{ $real_type_code->RoomTypeCode }}">{{ $real_type_code->RoomTypeCode }} : {{ $real_type_code->RoomTypeName }}</option>
                  @endforeach
                </select>
              @endif

              @if ($errors->has('RealTypeCode')) <!-- バリデーションメッセージ -->
              <div class="text-danger err_m">&lowast; {{ $errors->first('RealTypeCode') }}</div>
              @endif
              
            </div>

            <div class="d-flex room_type_wrap">
              <label for="" class="form-label">表示順</label>
              @if(isset($route_flag))

                @if($route_flag === 1)<!-- 詳細モード -->
                <input type="text" id="DisplayOrder" name="DisplayOrder" value="{{ $room_type->DisplayOrder }}" disabled maxlength="5" required>
                @elseif($route_flag === 2)<!-- 編集モード -->
                <input type="text" id="DisplayOrder" name="DisplayOrder" value="{{ $room_type->DisplayOrder }}" maxlength="5" required>
                @elseif($route_flag === 3)<!-- コピーモード -->
                <input type="text" id="DisplayOrder" class="enterTab" name="DisplayOrder" value="{{ $room_type['DisplayOrder'] }}" autofocus oninput="inputCode();" onblur="ztoh(this);" maxlength="5" required>
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
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($room_type !== null){{ $room_type->Hidden === 1 ? 'checked ' : '' }}@endif disabled>
                  @elseif($route_flag === 2)<!-- 編集 -->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($room_type !== null){{ $room_type->Hidden === 1 ? 'checked ' : '' }}@endif>
                  @elseif($route_flag === 3)<!-- コピーモード -->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($room_type !== null){{ $room_type['Hidden'] === 1 ? 'checked ' : '' }}@endif>
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
                <button type="button" class="btn me-4 btn-primary"><a style="color:#fff; text-decoration:none;" href="{{ route('RoomType.RoomType_index') }}">戻 る</a></button>
              @else
              <div class="d-flex">
                <!-- <button type="button" class="btn btn-primary back_btn" tabindex="" onclick="history.back()">戻 る</button> -->
                <button type="button" class="btn me-4 btn-primary"><a style="color:#fff; text-decoration:none;" href="{{ route('RoomType.RoomType_index') }}">戻 る</a></button>
                <button type="button" id="enter" class="btn btn-primary enterTab" tabindex="" onclick="createAlertRoomType()">確 定</button>
              </div>
              @endif

            @else
              <div class="d-flex">
                <!-- <button type="button" class="btn btn-primary back_btn" tabindex="" onclick="history.back()">戻 る</button> -->
                <button type="button" class="btn me-4 btn-primary"><a style="color:#fff; text-decoration:none;" href="{{ route('RoomType.RoomType_index') }}">戻 る</a></button>
                <button type="button" id="enter" class="btn btn-primary enterTab" tabindex="" onclick="createAlertRoomType()">確 定</button>
              </div>
            @endif
            
          </form>
        </div>

      </div>
    </div>

  </div>

</div>

@endsection