


<div class="btn_wrap d-flex" style="display:flex;">
    <button type="button" class="btn me-4 btn-primary"><a style="color:#fff; text-decoration:none;" href="{{ route('Person.Person_create') }}">新規作成</a></button>
    
    <form action="{{ route('Person.Person_edit') }}" method="post">
    @csrf
        <input type="hidden" name="editSearch" id="editPerson" value="{{ isset($person['PersonCode']) ? $person['PersonCode'] : '' }}">
        <button type="submit" class="btn me-4 btn-primary" onclick="return editAlert()">編 集</button>
    </form>

    <form action="{{ route('Person.Person_destroy') }}" method="post">
    @csrf
        <input type="hidden" name="deleteSearch" id="deletePerson" value="{{ isset($person['PersonCode']) ? $person['PersonCode'] : '' }}"></input> 
        <button type="submit" class="btn me-4 btn-primary" onclick="return destroy()">削 除</button>
    </form>

    <form action="{{ route('Person.Person_copy') }}" method="post">
    @csrf
        <input type="hidden" name="copySearch" id="copyPerson" value="{{ isset($person['PersonCode']) ? $person['PersonCode'] : '' }}">
        <input type="hidden" name="copyFlag" id="copyFlag" value="1">  
        <button type="submit" class="btn me-4 btn-primary" onclick="return copyAlert()">コピー</button>
    </form>
  
    <form action="{{ route('Person.Person_paste') }}" method="get">
    @csrf
        <input type="hidden" name="pasteFlag" id="pasteFlag" value="{{ session()->get('pasteFlag') == null ? session()->get('pasteFlag') : '' }}">
        <button type="submit" class="btn me-4 btn-primary" onclick="return pasteAlert()">貼付け</button>
    </form>
    <!-- <a href="{{ route('Person.Person_paste') }}">貼付け</a> -->
</div>


