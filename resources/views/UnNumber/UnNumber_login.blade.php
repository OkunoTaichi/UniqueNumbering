@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：一覧表示画面')

@section('UnNumber.content')
<div class="container">
  <h2>ログイン画面</h2><br/>

  <!-- バリデーション処理 -->
  @if(session('err_msg'))
    <p class="text-danger">
        {{ session('err_msg') }}
    </p>
  @endif

  @if ($errors->has('searchId')) 
    <div class="text-danger err_m">{{ $errors->first('searchId') }}</div>
  @endif
  @if ($errors->has('searchId_2')) 
    <div class="text-danger err_m">{{ $errors->first('searchId_2') }}</div>
  @endif
  <br/>
   <!-- バリデーション処理 -->

  <div class="row justify-content-center">
    @if (empty($tenantName))
    <!--検索フォーム-->
    <form method="GET" action="{{ route('UnNumber.index')}}">
      @csrf
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">テナントコード： </label>
        <div class="col-sm-5 d-flex">
          <!-- <input type="text" class="form-control" name="searchId" value="{{ $searchId }}"> -->
          <select class="form-select" id="searchId" name="searchId">
            @foreach ($s_tenants as $s_tenant)
                <option value="{{ $s_tenant->TenantCode }}" 
                @if((!empty($searchId) && $searchId == $s_tenant->TenantCode) || old('searchId') == $s_tenant->TenantCode)
                    selected
                @endif
                >{{ $s_tenant->TenantCode }}</option>
            @endforeach
          </select>
          <select class="form-select" id="searchId_2" name="searchId_2">
            @foreach ($s_tenantbranchs as $s_tenantbranch)
                <option value="{{ $s_tenantbranch->TenantBranch }}" 
                @if((!empty($searchId_2) && $searchId_2 == $s_tenantbranch->TenantBranch) || old('searchId_2') == $s_tenantbranch->TenantBranch)
                      selected
                  @endif
                >{{ $s_tenantbranch->TenantBranch }}</option>
            @endforeach
          </select>

        </div>
        <div class="col-sm-auto">
          <button type="submit" class="btn btn-primary ">検索</button>
        </div>
      </div>     
    </form>

      <!-- 無理矢理非表示 -->
      @if (!empty($tenantName))
      <div class="d-flex">
        <div class="d-flex">
          <p class="me-4">テナント会社名：{{ $tenantName->Tenants->CompanyName }}</p>
          <p class="">テナント施設名：{{ $tenantName->TenantBranchs->TenantBranchName}}</p>
        </div> 
      </div>
      <p>{{ $UnNumbers->count() }} 件表示</p>
      <br/>
      @endif 
      <!-- 無理矢理非表示 -->
      
    @endif 

    <!--検索結果テーブル 検索されたテナントコードがあった時のみ表示する-->
    @if (!empty($tenantName))

    <form method="post" action="/UnNumber/edit_delete" name="url">
      @csrf

      
      <div class="productTable">
        
       

        <div class="d-flex" style="display:flex;">
          <button type="button" class="btn btn-primary me-4"><a style="color:#fff;" href="{{ route('UnNumber.edit_create') }}">新規作成</a></button>
          <button type="button" class="btn btn-primary me-4" onclick="editTransition()">編 集</button>
          <button type="submit" class="btn btn-primary me-4" onclick="return checkDestroy()">削 除</button>
          <!-- <button type="button" class="btn btn-primary me-4" onclick="copyTransition()">コピー</button> -->
        </div>
        <br/>

          <table class="table table-hover">
            <thead style="background-color: #ffd900">
              <tr>
                <th></th>
                <th>採番区分</th>
                <th>初期値</th>
                <th>記号</th>
                <th>有効桁数</th>
                <th>編集区分</th>
                <th>日付区分</th>
              
              </tr>
            </thead>
            
            @foreach($UnNumbers as $UnNumber)

            <tr>
              <!-- javaScriptでURL変更 -->
              <td><input class="custom-control-input check" id="radio" name="id" type="radio" value="{{ $UnNumber->id }}"></td>
            
              <td>{{ $UnNumber->division_numbers[0]->DivName }}</td>
              <td>{{ $UnNumber->initNumber }}</td>
              <td>{{ $UnNumber->symbol }}</td>
              <td>{{ $UnNumber->lengs }}</td>
              <td>{{ $UnNumber->division_edits[0]->DivName }}</td>
              <td>{{ $UnNumber->division_dates[0]->DivName }}</td>
            </tr>
            @endforeach
          </table>
          <!-- ダミーのラジオボタン（ラジオボタンが１つだけだとＪＳが反応しない）要修正か所 -->
          <input class=""style="display:none;" id="radio" name="id" type="radio" value="">
        
      </div><!--テーブルここまで-->

    </form>
  
    




    <!--ページネーション-->
    <div class="d-flex justify-content-center">
      {{-- appendsでカテゴリを選択したまま遷移 --}}
      {{ $UnNumbers->appends(request()->input())->links() }}
    </div><!--ページネーションここまで-->
    @endif

    @if (!empty($UnNumbers))
      @if (empty($UnNumbers->count()))
        <p class="text-danger ">検索結果はありません。</p>
      @endif
    @endif
    
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


  </script>



  
</div>
@endsection