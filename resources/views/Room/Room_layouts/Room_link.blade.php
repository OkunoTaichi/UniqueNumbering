


<div class="btn_wrap d-flex" style="display:flex;">
    <button type="button" class="btn me-4 btn-primary"><a style="color:#fff; text-decoration:none;" href="{{ route('Room.Room_create') }}">新規作成</a></button>
    
    <form action="{{ route('Room.Room_edit') }}" method="post">
    @csrf
        <input type="hidden" name="edit_search" id="edit_search" value="{{ isset($room['RoomNo']) ? $room['RoomNo'] : '' }}">
        <button type="submit" class="btn me-4 btn-primary" onclick="return editAlert()">編 集</button>
    </form>

    <form action="{{ route('Room.Room_destroy') }}" method="post">
    @csrf
        <input type="hidden" name="delete_search" id="delete_search" value="{{ isset($room['RoomNo']) ? $room['RoomNo'] : '' }}"></input> 
        <button type="submit" class="btn me-4 btn-primary" onclick="return destroyAlert()">削 除</button>
    </form>

    <form action="{{ route('Room.Room_copy') }}" method="post">
    @csrf
        <input type="hidden" name="copy_search" id="copy_search" value="{{ isset($room['RoomNo']) ? $room['RoomNo'] : '' }}">
        <button type="submit" class="btn me-4 btn-primary" onclick="return copyAlert()">コピー</button>
    </form>
  
    <form action="{{ route('Room.Room_paste') }}" method="get">
    @csrf
        <input type="hidden" name="paste_flag" id="paste_flag" value="{{ session()->get('paste_flag') == null ? session()->get('paste_flag') : '' }}">
        <button type="submit" class="btn me-4 btn-primary" onclick="return pasteAlert()">貼付け</button>
    </form>
    <!-- <a href="{{ route('Person.Person_paste') }}">貼付け</a> -->
</div>


