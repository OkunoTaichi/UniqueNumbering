@extends('Person.Person_layouts.Person_layout')
@section('Person.Person_layouts.Person_layout.title', '採番マスタ：一覧表示画面')

@section('Person.content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="authority_wrap">
        @include('Person.Person_layouts.Person_link')<!-- 新規登録とかのボタン表示 -->
        <div class="form_parson">
        @if(session('successe_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('successe_msg') }}</p>
        @endif
          <div class="scroll_wrap">
            <table class="table table-hover">
              <thead style="background-color: #ffff9f" class="noScroll">
                <tr>
                  <th>担当者コード</th>
                  <th>氏       名</th>
                  <th>権限</th>
                  <th>非表示</th>
                  <th>表示順</th>
                </tr>
              </thead>
  
              <form action="{{ route('Person.Person_detail') }}" method="post">
                @csrf
                <tbody>
                    @foreach ($persons as $person)
                    <tr>
                        <td><input type="submit" class="text" style="border:none; background-color: inherit;" name="editSearch" value="{{ $person->PersonCode }}"></input></td>
                        <td>{{ $person->PersonName }}</td>
                        <td>{{ $person->AuthorityCode }}</td>
                        <td>
                          <div class="disabled">
                            <input type="checkbox" name="" class="form-control3 enterTab" id="" value="1" {{ $person->Hidden === 1 ? 'checked' : '' }} disabled>
                          </div>
                        </td>
                        <td>{{ $person->DisplayOrder }}</td>
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