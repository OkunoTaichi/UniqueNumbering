


<div class="btn_wrap d-flex" style="display:flex;">
    <button type="button" class="btn me-4 btn-primary"><a style="color:#fff; text-decoration:none;" href="{{ route('Building.Building_create') }}">新規作成</a></button>
    
    <form action="{{ route('Building.Building_edit') }}" method="post">
    @csrf
        <input type="hidden" name="edit_search" id="edit_search" value="{{ isset($building['BuildingCode']) ? $building['BuildingCode'] : '' }}">
        <button type="submit" class="btn me-4 btn-primary" onclick="return editAlert()">編 集</button>
    </form>

    <form action="{{ route('Building.Building_destroy') }}" method="post">
    @csrf
        <input type="hidden" name="delete_search" id="delete_search" value="{{ isset($building['BuildingCode']) ? $building['BuildingCode'] : '' }}"></input> 
        <button type="submit" class="btn me-4 btn-primary" onclick="return destroyAlert()">削 除</button>
    </form>

    <form action="{{ route('Building.Building_copy') }}" method="post">
    @csrf
        <input type="hidden" name="copy_search" id="copy_search" value="{{ isset($building['BuildingCode']) ? $building['BuildingCode'] : '' }}">
        <button type="submit" class="btn me-4 btn-primary" onclick="return copyAlert()">コピー</button>
    </form>
  
    <form action="{{ route('Building.Building_paste') }}" method="get">
    @csrf
        <input type="hidden" name="pasteFlag" id="pasteFlag" value="{{ session()->get('pasteFlag') == null ? session()->get('pasteFlag') : '' }}">
        <button type="submit" class="btn me-4 btn-primary" onclick="return pasteAlert()">貼付け</button>
    </form>
    <!-- <a href="{{ route('Person.Person_paste') }}">貼付け</a> -->
</div>


