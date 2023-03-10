@extends('RoomType.RoomType_layouts.RoomType_layout')
@section('RoomType.RoomType_layouts.RoomType_layout.title', '採番マスタ：一覧表示画面')

@section('RoomType.content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="authority_wrap">
        @include('RoomType.RoomType_layouts.RoomType_link')<!-- 新規登録とかのボタン表示 -->
        <div class="form_room_type">
        @if(session('successe_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('successe_msg') }}</p>
        @endif
          <div class="scroll_wrap">
            <table class="table table-hover">
              <thead style="background-color: #ffff9f;" class="noScroll">
                <tr style="padding: 5px;" class="room_tr">
                  <th>タイプコード</th>
                  <th>部屋タイプ名称</th>
                  <th>略称</th>
                  <th>部屋種別</th>
                  <th>稼働計上</th>
                  <th>残室表示</th>
                  <th>実タイプ</th>
                  <th>部屋実タイプ名称</th>
                  <th>表示順</th>
                  <th>非表示</th>
                </tr>
              </thead>
  
              <form action="{{ route('RoomType.RoomType_detail') }}" method="post">
                @csrf
                <tbody>
                  @foreach ($room_types as $room_type)
                  <tr class="linkWrap">
                    <td class="linkCode">
                      <input type="submit" class="text authorityLinks" style="border:none; background-color: inherit;" name="search_code" value="{{ $room_type->RoomTypeCode }}"></input>        
                    </td>


                    <td class="links" style="border:none; background-color: inherit;">{{ $room_type->RoomTypeName }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room_type->RoomTypeAbName}}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room_type->division_room_type_divs[0]['DivName'] }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room_type->division_operation_divs[0]['DivName'] }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room_type->division_remaining_room_divs[0]['DivName'] }}</td>

                    <td class="links" style="border:none; background-color: inherit;">{{ isset($room_type->Real[0]) ? $room_type->Real[0]['RoomTypeCode'] : '-' }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ isset($room_type->Real[0]) ? $room_type->Real[0]['RoomTypeName'] : '-' }}</td>
                    
                    <td class="links" style="border:none; background-color: inherit;">{{ $room_type->DisplayOrder }}</td>
                
                    <td class="links" style="border:none; background-color: inherit;">
                      <div class="disabled">
                        <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="" value="1" {{ $room_type -> Hidden === 1 ? 'checked' : '' }} disabled>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                   
                   
                </tbody>
              </form>
  
            </table>
          </div>

        </div>

        

        

         
      </div>
    </div>

  </div>

</div>
<script>



  

</script>
@endsection