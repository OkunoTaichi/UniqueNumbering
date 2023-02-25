@extends('Authority.Authority_layouts.Authority_layout')
@section('Authority.Authority_layouts.Authority_layout.title', '採番マスタ：一覧表示画面')

@section('Authority.content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="authority_wrap">

        <div class="btn_wrap d-flex" style="display:flex;">
          <button type="button" class="btn me-4 btn-primary"><a style="color:#fff; text-decoration:none;" href="{{ route('Authority.Authority_index') }}">新規作成</a></button>
          
          <form action="{{ route('Authority.Authority_edit') }}" method="post">
            @csrf
            <input type="hidden" name="editSearch" id="editAuthority" value="{{ isset($Authority['AuthorityCode']) ? $Authority['AuthorityCode'] : '' }}">
            <input type="hidden" name="editFlag" id="editFlag" value="3">
            <button type="submit" class="btn me-4 btn-primary" onclick="return editAlert()">編 集</button>
          </form>

          <form action="{{ route('Authority.Authority_destroy') }}" method="post">
            @csrf
            <input type="hidden" name="deleteSearch" id="deleteAuthority" value="{{ isset($Authority['AuthorityCode']) ? $Authority['AuthorityCode'] : '' }}"></input> 
            <button type="submit" class="btn me-4 btn-primary" onclick=" return destroy()">削 除</button>
          </form>
     
          <form action="{{ route('Authority.Authority_edit') }}" method="post">
            @csrf
            <input type="hidden" name="editSearch" id="copyAuthority" value="{{ isset($Authority['AuthorityCode']) ? $Authority['AuthorityCode'] : '' }}">
            <input type="hidden" name="copyFlag" id="copyFlag" value="4">  
            <button type="submit" class="btn me-4 btn-primary" onclick=" return copyAlert()">コピー</button>
          </form>
          <button type="button" class="btn btn-secondary me-4" disabled>貼付け</button>
        </div>

        <div class="err-wrap">
          @if(session('err_msg'))<!-- 登録確認、存在チェックの表示 -->
            <h1 class="text-danger error fadeIn">
                {{ session('err_msg') }}
            </h1>
          @endif

          @if(session('err_msg_index'))<!-- 登録確認、存在チェックの表示 -->
            <h1 class="text-danger error fadeIn">
                {{ session('err_msg') }}
            </h1>
          @endif
     

          @if($routeFlg == 3)
            <h1 class="text-danger error">編集中</h1>
          @endif

          <div class="err-1"><!-- バリデーションチェックの表示 -->
            @if ($errors->has('AuthorityCode')) 
                <div class="text-danger err_m">&lowast; {{ $errors->first('AuthorityCode') }}</div>
            @endif
            @if ($errors->has('AuthorityName')) 
                <div class="text-danger err_m">&lowast; {{ $errors->first('AuthorityName') }}</div>
            @endif

            @if ($errors->has('AdminFlg')) 
                <div class="text-danger err_m">&lowast; {{ $errors->first('AdminFlg') }}</div>
            @endif

            @if ($errors->has('AuthorityDiv.*')) 
                <div class="text-danger err_m">&lowast; {{ $errors->first('AuthorityDiv.*') }}</div>
            @endif
          </div>
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

              <form action="{{ route('Authority.Authority_edit') }}" method="post">
                @csrf
                <tbody>
                  @foreach ($authoritys as $authority)
                  <tr>
                    <td>
                      <input type="submit" class="text" style="border:none; background-color: inherit;" name="editSearch" value="{{ $authority->AuthorityCode }}"></input>        
                    </td>

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

          <form name="AuthorityForm" method="post" action="{{ route('Authority.Authority_store') }}" onsubmit="return false;">
          @csrf
          <div class="form_input">
            <div class="input_wrap d-flex">
              <label for="AuthorityCode" class="form-label2" style="background-color: #ffff9f">権限CD</label>

              @if( $routeFlg == 4)
              <input type="text" name="AuthorityCode" class="form-control2 enterTab" id="AuthorityCode" value="" oninput="inputCode();" {{ $routeFlg == 2 ? 'disabled' : 'autofocus' }}>
              @elseif( $routeFlg == 3)
              <input type="text" name="AuthorityCode" class="form-control2 enterTab noLine" id="AuthorityCode" value="{{ isset($Authority['AuthorityCode']) ? $Authority['AuthorityCode'] : '' }}" oninput="inputCode();" readonly>
              @else
              <input type="text" name="AuthorityCode" class="form-control2 enterTab" id="AuthorityCode" value="{{ isset($Authority['AuthorityCode']) ? $Authority['AuthorityCode'] : '' }}" oninput="inputCode();" {{ $routeFlg == 2 ? 'disabled' : 'autofocus' }}>
              @endif

              <input type="text" name="AuthorityName" class="form-control2 enterTab" id="AuthorityName" value="{{ isset($Authority['AuthorityName']) ? $Authority['AuthorityName'] : '' }}" {{ $routeFlg == 2 ? 'disabled' : '' }}>
              </br>
              <label for="AdminFlg" class="form-label2" style="background-color: #ffff9f">システム管理者</label>
              <div class="check-wrap {{ $routeFlg == 2 ? 'disabled' : '' }}">
                <input type="hidden" name="AdminFlg">
                @if(isset($AdminFlg) || $AdminFlg === 1 )
                <input type="checkbox" name="AdminFlg" class="form-control3 enterTab" id="AdminFlg" value="1" checked {{ $routeFlg == 2 ? 'disabled' : '' }}>
                @else
                <input type="checkbox" name="AdminFlg" class="form-control3 enterTab" id="AdminFlg" value="1" {{ $routeFlg == 2 ? 'disabled' : '' }}>
                @endif
              </div>
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
                  
                    <td><label class="{{ $routeFlg == 2 ? 'disabled' : '' }}"><input class="radioAll_1" type="radio" value="1" name="AuthorityDiv[{{ $i }}]" 
                    @if(isset($AuthorityDetail))
                      @if( $AuthorityDetail[$i]['AuthorityDiv'] == 1 ) checked @endif
                    @endif
                    {{ $routeFlg == 2 ? 'disabled' : '' }}></label></td>

                    <td><label class="{{ $routeFlg == 2 ? 'disabled' : '' }}"><input class="radioAll_2" type="radio" value="2" name="AuthorityDiv[{{ $i }}]" 
                    @if(isset($AuthorityDetail))
                      @if( $AuthorityDetail[$i]['AuthorityDiv'] == 2 ) checked @endif
                    @endif
                    {{ $routeFlg == 2 ? 'disabled' : '' }}></label></td>

                    <td><label class="{{ $routeFlg == 2 ? 'disabled' : '' }}"><input class="radioAll_3" type="radio" value="3" name="AuthorityDiv[{{ $i }}]" 
                    @if(isset($AuthorityDetail))
                      @if( $AuthorityDetail[$i]['AuthorityDiv'] == 3 ) checked @endif
                    @endif

                    @if(!isset($AuthorityDetail))
                       checked
                    @endif
                    {{ $routeFlg == 2 ? 'disabled' : '' }}></label></td><!-- から送信対策。 --> 
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
          <button type="button" class="btn btn-primary enterTab" onclick="createEdit()" id="enter">確 定</button>
        </div>
          
        

      </form>
      </div>
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


  
  // 編集と削除インプットに権限CDの入力値を入れる
  function inputCode(){
    AuthorityCode =document.getElementById('AuthorityCode').value;
    document.getElementById( 'deleteAuthority' ).value = AuthorityCode ;
    document.getElementById( 'editAuthority' ).value = AuthorityCode ;
    document.getElementById( 'copyAuthority' ).value = AuthorityCode ;
  }

  function createEdit(){
    if(window.confirm('登録してよろしいですか？')){
        document.AuthorityForm.submit();
        return true;
    } else {
        return false;
    }
  }

  function destroy(){
    deleteAuthority = document.getElementById('deleteAuthority').value;

    if(deleteAuthority == ''){
      alert( '削除する権限CDを入力するか選択して下さい。' );
      return false;
    }else{

      if(window.confirm('削除してよろしいですか？')){
          return true;
      } else {
          return false;
      }
    }
  }

  function editAlert(){
    editAuthority = document.getElementById('editAuthority').value;

    if(editAuthority == ''){
      alert( '編集する権限CDを入力するか選択して下さい。' );
      return false;
    }
  }

  function copyAlert(){
    editAuthority = document.getElementById('copyAuthority').value;

    if(editAuthority == ''){
      alert( 'コピーする権限CDを入力するか選択して下さい。' );
      return false;
    }
  }



  

</script>
@endsection