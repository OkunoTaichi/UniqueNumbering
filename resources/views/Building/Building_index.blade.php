@extends('Building.Building_layouts.Building_layout')
@section('Building.Building_layouts.Building_layout.title', '採番マスタ：一覧表示画面')

@section('Building.content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="authority_wrap">
        @include('Building.Building_layouts.Building_link')<!-- 新規登録とかのボタン表示 -->
        <div class="form_parson">
        @if(session('successe_msg'))<!-- 登録確認、存在チェックの表示 -->
          <p class="text-danger error fadeIn">{{ session('successe_msg') }}</p>
        @endif
          <div class="scroll_wrap">
            <table class="table table-hover">
              <thead style="background-color: #ffff9f;" class="noScroll">
                <tr style="padding: 5px;">
                  <th>棟コード</th>
                  <th>棟 名 称</th>
                  <th class="">棟 略 称</th>
                  <th>表示順</th>
                  <th>非表示</th>
                </tr>
              </thead>
  
              <form action="{{ route('Building.Building_detail') }}" method="post">
                @csrf
                <tbody>
                  @foreach ($buildings as $building)
                  <tr class="linkWrap">
                    <td class="linkCode">
                      <input type="submit" class="text authorityLinks" style="border:none; background-color: inherit;" name="search_code" value="{{ $building->BuildingCode }}"></input>        
                    </td>

                    <td class="links" style="border:none; background-color: inherit;">{{ $building->BuildingName }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $building->BuildingAbName }}</td>
                    <td class="links" style="border:none; background-color: inherit;">{{ $building->DisplayOrder }}</td>
                    <td class="links" style="border:none; background-color: inherit;">
                      <div class="disabled">
                        <input type="checkbox" name="" class="form-control3 enterTab" id="" value="1" {{ $building->Hidden === 1 ? 'checked' : '' }} disabled>
                      </div>
                    </td>
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