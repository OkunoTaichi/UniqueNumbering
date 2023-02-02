@extends('UnNumber.UnNumber_layouts.UnNumber_layout')
@section('UnNumber.UnNumber_layouts.UnNumber_layout.title', '採番マスタ：一覧表示画面')

@section('UnNumber.content')
<div class="container">
  <h2>予約区分一覧画面</h2><br/>

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
    
    <!--検索結果テーブル 検索されたテナントコードがあった時のみ表示する-->
    @if (!empty($tenantName))
    <div class="productTable">
      <div class="d-flex">
        <div class="">
          <p class="">テナント会社名：{{ $tenantName->Tenants->CompanyName }}</p>
          <p class="">テナント施設名：{{ $tenantName->TenantBranchs->TenantBranchName}}</p>
        </div> 
      </div>
      <p>{{ $UnNumbers->count() }} 件表示</p>

      <table class="table table-hover">
        <thead style="background-color: #ffd900">
          <tr>
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
          <td>{{ $UnNumber->NumberDivs->number_name }}</td>
          <td>{{ $UnNumber->initNumber }}</td>
          <td>{{ $UnNumber->symbol }}</td>
          <td>{{ $UnNumber->DivEdits->edit_length }}</td>
          <td>{{ $UnNumber->DivEdits->edit_name }}</td>
          <td>{{ $UnNumber->DivDates->date_name }}</td>
        </tr>
        @endforeach
      </table>

    </div><!--テーブルここまで-->
    
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
</div>
@endsection