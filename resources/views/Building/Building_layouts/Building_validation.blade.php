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