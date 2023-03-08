@extends('Room.Room_layouts.Room_layout')
@section('Room.Room_layouts.Room_layout.title', '採番マスタ：一覧表示画面')

@section('Room.content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="authority_wrap">
        @include('Room.Room_layouts.Room_link')<!-- 新規登録とかのボタン表示 -->
        <div class="form_parson">
        @if(session('successe_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('successe_msg') }}</p>
        @endif
          <div class="scroll_wrap">
            <table class="table table-hover">
              <thead style="background-color: #ffff9f;" class="noScroll">
                <tr style="padding: 5px;" class="room_tr">
                  <th>部屋番号</th>
                  <th>棟コード</th>
                  <th>部屋タイプ</th>
                  <th>部 屋 名 称</th>
                  <th>部屋略称</th>
                  <th>定員<br/>（MAX)</th>
                  <th>定員<br/>（MIN)</th>
                  <th>フロア</th>
                  <th>稼働</th>
                  <th>表示順</th>
                  <th>非表示</th>
                </tr>
              </thead>
  
              <form action="{{ route('Room.Room_detail') }}" method="post">
                @csrf
                <tbody>
                  @foreach ($rooms as $room)
                  <tr class="linkWrap">
                    <td class="linkCode">
                      <input type="submit" class="text authorityLinks" style="border:none; background-color: inherit;" name="search_code" value="{{ $room->RoomNo }}"></input>        
                    </td>

                    <td class="links" style="border:none; background-color: inherit;">{{ $room->BuildingCode }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room->RoomTypeCode }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room->RoomName }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room->RoomAbName }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room->CapacityMax }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room->CapacityMin }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room->Floor }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room->Hidden }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $room->DisplayOrder }}</td>
                    <td class="links" style="border:none; background-color: inherit;">
                      <div class="disabled">
                        <input type="checkbox" name="" class="form-control3 enterTab" id="" value="1" {{ $room->Hidden === 1 ? 'checked' : '' }} disabled>
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