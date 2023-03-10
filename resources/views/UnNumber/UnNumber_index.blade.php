@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：一覧表示画面')

@section('UnNumber.content')
<div class="container">
  <!-- <h2>予約区分一覧画面</h2> -->

  <!-- バリデーション処理 -->
  @if(session('err_msg'))
    <p class="text-danger">
        {{ session('err_msg') }}
    </p>
  @endif
  @if(isset($m_numberings[0]))
  <div class="row justify-content-center">
      <div class="d-flex">
        <div class="d-flex">
          <p class="me-4">テナント会社名：{{ $m_numberings[0]->TenantCode }}</p>
          <p class="">テナント施設名：{{ $m_numberings[0]->TenantBranch }}</p>
        </div> 
      </div>
      <!-- <p>{{ $m_numberings->count() }} 件表示</p> -->
      <br/>
  @endif
    <form method="post" action="/UnNumber/edit_delete" name="url">
      @csrf
      <div class="productTable">
        <div class="d-flex" style="display:flex;">
          <button type="button" class="btn btn-primary me-4"><a style="color:#fff; text-decoration:none;" href="{{ route('UnNumber.edit_create') }}">新規作成</a></button>
          <button type="button" class="btn btn-primary me-4" onclick="editTransition()">編 集</button>
          <button type="submit" class="btn btn-primary me-4" onclick="return checkDestroy()">削 除</button>
          <button type="button" class="btn btn-primary me-4" onclick="copyTransition()">コピー</button>
          <button type="button" class="btn btn-primary me-4" onclick="pasteTransition()">貼付け</button>
        </div>
        <br/>
        
        @if(isset($m_numberings[0]))
          <table class="table table-hover">
            <thead style="background-color: #ffd900">
              <tr>
                <th></th>
                <th>採番区分</th>
                <th>初期値</th>
                <th>編集区分</th>
                <th>記号</th>
                <th>有効桁数</th>
                <th>日付区分</th>
                <th>採番クリア区分</th>
              </tr>
            </thead>
            
            @foreach($m_numberings as $m_numbering)

            <tr>
              <!-- javaScriptでURL変更 -->
              <td><input class="custom-control-input check" id="radio" name="id" type="radio" value="{{ $m_numbering->id }}"></td>
            
              <td>{{ $m_numbering->division_numbers[0]->DivNo }} : {{ $m_numbering->division_numbers[0]->DivName }}</td>
              <td>{{ $m_numbering->initNumber }}</td>
              <td>{{ $m_numbering->division_edits[0]->DivName }}</td>
              <td>{{ $m_numbering->symbol }}</td>
              <td>{{ $m_numbering->lengs }}</td>
              <td>{{ $m_numbering->division_dates[0]->DivName }}</td>
              <td>{{ $m_numbering->division_numberclears[0]->DivName }}</td>
            </tr>
            @endforeach
          </table>
          <!-- ダミーのラジオボタン（ラジオボタンが１つだけだとＪＳが反応しない）要修正か所 -->
          <input class=""style="display:none;" id="radio" name="id" type="radio" value="">
        @else
        <p class="text-danger">登録がありません。</p>
        @endif
      </div><!--テーブルここまで-->

    </form>
    <!--ページネーション-->
    <div class="d-flex justify-content-center">
    {{ $m_numberings->appends(request()->input())->links() }}
    </div><!--ページネーションここまで-->
  </div>

  




  <script>

    function editTransition(){
      let flag = false; // 選択されているか否かを判定するフラグ
      let $url = "/UnNumber/edit_edit/";
      // ラジオボタンの数だけ判定を繰り返す（ボタンを表すインプットタグがあるので１引く）
      for(var i=0; i<document.url.id.length;i++){
          // i番目のラジオボタンがチェックされているかを判定
          if(document.url.id[i].checked){ 
              flag = true;
              // alert($url + document.url.edit[i].value + "が選択されました。");
              window.location.href = $url + document.url.id[i].value; 
          }
      }
      // 何も選択されていない場合の処理
      if(!flag){ 
          alert("項目が選択されていません。");
      }
    }

    // ラジオボタンを選択後に直で削除
    function checkDestroy(){
      var flag = false; 
      for(var i=0; i<document.url.id.length;i++){
          if(document.url.id[i].checked){ 
              flag = true; 
          }
      }
      if(!flag){ 
          alert("項目が選択されていません。");
          return false;
      }
      if(window.confirm('削除してよろしいですか？')){
          return true;
      } else {
          return false;
      }
    }
    document.onkeypress = function(e) {
      // エンターキーだったら無効にする
      if (e.key === 'Enter') {
        return false;
      }
    }


    function copyTransition(){
      let flag = false; 
      let $url = "/UnNumber/edit_copy/";
      for(var i=0; i<document.url.id.length;i++){
          if(document.url.id[i].checked){ 
              flag = true;
              window.location.href = $url + document.url.id[i].value; 
          }
      }
      // 何も選択されていない場合の処理
      if(!flag){ 
          alert("項目が選択されていません。");
      }
    }

    function pasteTransition(){
      let $session = @json(Session::get('numberName'));
      let $url = "/UnNumber/edit_paste/";
      if(!$session){ 
          alert("コピーしていません。");
      }else{
        window.location.href = $url;
      }
    }


  </script>



  
</div>
@endsection