@extends('Authority.Authority_layouts.Authority_layout')
@section('Authority.Authority_layouts.Authority_layout.title', '採番マスタ：一覧表示画面')

@section('Authority.content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <form method="post" action="{{ route('Authority.Authority_store') }}" class="authority_wrap" onsubmit="return false;">
        @csrf
    
        <div class="btn_wrap d-flex" style="display:flex;">
          <button type="button" class="btn btn-primary me-4"><a style="color:#fff; text-decoration:none;" href="">新規作成</a></button>
          <button type="button" class="btn btn-primary me-4" onclick="editTransition()">編 集</button>
          <button type="submit" class="btn btn-primary me-4" onclick="return checkDestroy()">削 除</button>
          <button type="button" class="btn btn-primary me-4" onclick="copyTransition()">コピー</button>
          <button type="button" class="btn btn-primary me-4" onclick="pasteTransition()">貼付け</button>
        </div>

        <div class="form_container d-flex">

          <div class="form_auth scroll_wrap" style="height: 380px;">
            <table class="table table-hover">
              <thead style="background-color: #ffff9f" class="noScroll">
                
                <tr>
                  <th>権限CD</th>
                  <th>権 限 名 称</th>
                </tr>
              </thead>

              <form action="" method="post">
                @csrf
                <tbody>
                  @foreach ($authoritys as $authority)
                  <tr>
                    <td>{{ $authority->AuthorityCode }}</td>
                    <td>{{ $authority->AuthorityName }}</td>
                  </tr>
                  @endforeach
                
                  @if($authoritys->count() < 8 )
                    <!-- 高さ分だけ空標示 -->
                    @for ($i = $authoritys->count(); $i < 8; $i++)
                    <tr style="height: 40px;">
                      <td></td>
                      <td></td>
                    </tr>
                    @endfor
                  @endif  
                </tbody>
              </form>
            </table>
          </div>

          <div class="form_input">
            <div class="input_wrap d-flex">
              <label for="AuthorityCode" class="form-label2" style="background-color: #ffff9f">権限CD</label>
              <input type="text" name="AuthorityCode" class="form-control2 enterTab" id="AuthorityCode" value="">
              <input type="text" name="AuthorityName" class="form-control2 enterTab" id="AuthorityName" value="">
              </br>
              <label for="AdminFlg" class="form-label2" style="background-color: #ffff9f">システム管理者</label>
              <input type="hidden" name="AdminFlg">
              <input type="checkbox" name="AdminFlg" class="form-control3 enterTab" id="AdminFlg" value="1">
            </div>

            <div class="program_wrap scroll_wrap">
              <table class="table table-hover p_table">
                <thead style="background-color: #ffff9f" class="noScroll">
                  <tr>
                    <th colspan="2">プログラム</th>
                    <th><button type="button" id="radioA"  style="border:none; background-color: inherit;">更新</button></th>
                    <th><button type="button" id="radioB"  style="border:none; background-color: inherit;">参照</button></th>
                    <th><button type="button" id="radioC"  style="border:none; background-color: inherit;">不可</button></th>
                  </tr>
                </thead>

                <tbody class="p_scroll">

                  @foreach ($programs as $i => $program)
           
                  <tr>
                 
                    <td><input type="hidden" name="ProgramID[{{ $i }}]" class="form-control2" id="ProgramID" value="{{ $program->ProgramID }}">{{ $program->ProgramID }}</td>
                    <td class="t_start" style="padding-left: 30px"><input type="hidden" name="" class="form-control2" id="ProgramName" value="">{{ $program->ProgramName }}</td>
                    
                  
                    <td><label><input class="enterTab radioAll_1" type="radio" value="1" name="AuthorityDiv[{{ $i }}]"></label></td>
                    <td><label><input class="enterTab radioAll_2" type="radio" value="2" name="AuthorityDiv[{{ $i }}]"></label></td>
                    <td><label><input class="enterTab radioAll_3" type="radio" value="3" name="AuthorityDiv[{{ $i }}]" checked></label></td>
                    
                  </tr> 
                  @endforeach
                  

                  @if($programs->count() < 6 )
                    <!-- 高さ分だけ空標示 -->
                    @for ($i = $programs->count(); $i < 6; $i++)
                    <tr style="height: 40px;">
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    @endfor
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
        
        <div class="mt-5 submit_wrap">
          <button type="button" class="btn btn-primary enterTab" onclick="submit()" id="enter">確 定</button>
        </div>
          
        

      </form>
    </div>

  </div>

</div>
<script>
  // 更新とかのボタンでラジオボタン全選択（取り敢えず個別に作成）
  document.getElementById('radioA').addEventListener('click', function(){
    var elems = document.querySelectorAll('.radioAll_1');
    for (var i = 0; i < elems.length; i++){
      elems[i].checked = true;
    }
  })
  document.getElementById('radioB').addEventListener('click', function(){
    var elems = document.querySelectorAll('.radioAll_2');
    for (var i = 0; i < elems.length; i++){
      elems[i].checked = true;
    }
  })
  document.getElementById('radioC').addEventListener('click', function(){
    var elems = document.querySelectorAll('.radioAll_3');
    for (var i = 0; i < elems.length; i++){
      elems[i].checked = true;
    }
  })

</script>
@endsection