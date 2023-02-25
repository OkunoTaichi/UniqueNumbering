@extends('Person.Person_layouts.Person_layout')
@section('Person.Person_layouts.Person_layout.title', '採番マスタ：一覧表示画面')

@section('Person.content')


<div class="container">
  
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="person_wrap">
        @include('Person.Person_layouts.Person_link')<!-- 新規登録とかのボタン表示 -->  
        <div class="form_parson">

        @if(session('err_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('err_msg') }}</p>
        @endif

          <form name="PersonForm" action="{{ route('Person.Person_store') }}" method="post">
            @csrf

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">担当者コード</label>
              @if(isset($routeFlag))

                @if($routeFlag === 1)<!-- 詳細モード -->
                <input type="text" id="PersonCode" name="PersonCode" value="{{ $person->PersonCode }}" disabled>
                @elseif($routeFlag === 2)<!-- 編集モード -->
                <input type="text" id="PersonCode" name="PersonCode" value="{{ $person->PersonCode }}" readonly>
                @elseif($routeFlag === 3)<!-- コピーモード -->
                <input type="text" id="PersonCode" name="PersonCode" value="" cheked oninput="inputCode();">
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="PersonCode" name="PersonCode" value="" cheked oninput="inputCode();">
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="PersonCode" name="PersonCode" value="" cheked oninput="inputCode();">
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">氏名</label>
              @if(isset($routeFlag))

                @if($routeFlag === 1)<!-- 詳細モード -->
                <input type="text" id="PersonName" name="PersonName" value="{{ $person->PersonName }}" disabled>
                @elseif($routeFlag === 2)<!-- 編集モード -->
                <input type="text" id="PersonName" name="PersonName" value="{{ $person->PersonName }}" cheked>
                @elseif($routeFlag === 3)<!-- コピーモード -->
                <input type="text" id="PersonName" name="PersonName" value="{{ $person->PersonName }}">
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="PersonName" name="PersonName" value="">
                @endif

              @else<!-- 新規作成モード -->
              <input type="text" id="PersonName" name="PersonName" value="">
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="AuthorityCode" class="form-label">権限</label>
              @if(isset($routeFlag))

                @if($routeFlag === 1)<!-- 詳細モード -->
                <input type="text" id="AuthorityCode" name="AuthorityCode" value="{{ $person->AuthorityCode }}" disabled>

                @elseif($routeFlag === 2 || $routeFlag === 3)<!-- 編集＋コピーモード -->
                <select class="form-select enterTab" id="AuthorityCode" name="AuthorityCode">
                  <option value="{{ $person->AuthorityCode }}">{{ $person->AuthorityCode }}</option>   
                  @foreach ($authoritys as $authority)
                  <option value="{{ $authority->AuthorityCode }}">{{ $authority->AuthorityCode }} : {{ $authority->AuthorityName }}</option>   
                  @endforeach
                </select>

                @else<!-- 新規作成モード （保険）-->
                <select class="form-select enterTab" id="AuthorityCode" name="AuthorityCode">
                  @foreach ($authoritys as $authority)
                  <option value="{{ $authority->AuthorityCode }}">{{ $authority->AuthorityCode }} : {{ $authority->AuthorityName }}</option>   
                  @endforeach
                </select>
                @endif
                
              @else
                <!-- 新規作成モード -->
                <select class="form-select enterTab" id="AuthorityCode" name="AuthorityCode">
                  @foreach ($authoritys as $authority)
                  <option value="{{ $authority->AuthorityCode }}">{{ $authority->AuthorityCode }} : {{ $authority->AuthorityName }}</option>   
                  @endforeach
                </select>
              @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">パスワード</label>
                @if(isset($routeFlag))

                  @if($routeFlag === 1)<!-- 詳細モード -->
                  <input type="text" id="Password" name="Password" value="{{ $person->Password }}" disabled>
                  @elseif($routeFlag === 2 || $routeFlag === 3)<!-- 編集＋コピーモード -->
                  <input type="text" id="Password" name="Password" value="{{ $person->Password }}">
                  @else<!-- 新規作成モード （保険）-->
                  <input type="text" id="Password" name="Password" value="">
                  @endif

                @else<!-- 新規作成モード -->
                <input type="text" id="Password" name="Password" value="">
                @endif
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">非表示</label>
              <div class="disabled">
                @if(isset($routeFlag))

                  @if($routeFlag === 1)<!-- 詳細モード -->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($person !== null){{ $person->Hidden === 1 ? 'checked ' : '' }}@endif disabled>
                  @elseif($routeFlag === 2 || $routeFlag === 3)<!-- 編集＋コピーモード -->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1" @if($person !== null){{ $person->Hidden === 1 ? 'checked ' : '' }}@endif>
                  @else<!-- 新規作成モード （保険）-->
                  <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1">
                  @endif

                @else<!-- 新規作成モード -->
                <input type="checkbox" name="Hidden" class="form-control3 enterTab" id="Hidden" value="1"> 
                @endif
              </div>
            </div>

            <div class="d-flex input_parson_wrap">
              <label for="" class="form-label">表示順</label>
              @if(isset($routeFlag))

                @if($routeFlag === 1)<!-- 詳細モード -->
                <input type="text" id="DisplayOrder" name="DisplayOrder" value="{{ $person->DisplayOrder }}" disabled>
                @elseif($routeFlag === 2 || $routeFlag === 3)<!-- 編集＋コピーモード -->
                <input type="text" id="DisplayOrder" name="DisplayOrder" value="{{ $person->DisplayOrder }}">
                @else<!-- 新規作成モード （保険）-->
                <input type="text" id="DisplayOrder" name="DisplayOrder" value="">
                @endif

              @else<!-- 新規作成モード -->  
              <input type="text" id="DisplayOrder" name="DisplayOrder" value="">
              @endif
            </div>

            @if(isset($routeFlag))

              @if($routeFlag === 1)<!-- 詳細モードは確定なし -->
                <button type="button" class="btn btn-primary enterTab" tabindex="" onclick="history.back()" id="enter">戻 る</button>
              @else
              <div class="d-flex">
                <button type="button" class="btn btn-primary enterTab back_btn" tabindex="" onclick="history.back()" id="enter">戻 る</button>
                <button type="button" class="btn btn-primary enterTab" tabindex="" onclick="submit()" id="enter">確 定</button>
              </div>
              @endif

            @else
              <div class="d-flex">
                <button type="button" class="btn btn-primary enterTab back_btn" tabindex="" onclick="history.back()" id="enter">戻 る</button>
                <button type="button" class="btn btn-primary enterTab" tabindex="" onclick="submit()" id="enter">確 定</button>
              </div>
            @endif
            
          </form>
        </div>

      </div>
    </div>

  </div>

</div>

@endsection