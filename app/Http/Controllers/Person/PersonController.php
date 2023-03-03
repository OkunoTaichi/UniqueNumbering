<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Person\PersonRequest;
use DB;
use App\Models\Person\M_Person;
use App\Models\Authority\M_Authority;

class PersonController extends Controller
{
    
    public function Person_index()
    {
        // 使用するモデル
        $M_Person = new M_Person;
        \Session::forget('routeFlg');
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // AuthorityCodeとNameを紐づけて表示
        $persons = $M_Person->AuthorityName($tenantCode,$tenantBranch);

        return view(
            'Person.Person_index' ,compact('persons')
        );
    }

    public function Person_create()
    {
        // 使用するモデル
        $M_Person = new M_Person;
        // 新規作成モード
        \Session::put(['routeFlag' => 0]);
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // セレクトボックスに登録されている権限を表示する
        $authoritys = M_Authority::orderBy('AuthorityCode', 'asc')->get();
        // AuthorityCodeとNameを紐づけて表示
        $persons = $M_Person->AuthorityName($tenantCode,$tenantBranch);
       
        return view(
            'Person.Person_create' ,compact('persons','authoritys',)
        );
    }

    public function Person_detail(Request $request){
        // 使用するモデル
        $M_Person = new M_Person;
        $M_Authority = new M_Authority;
        // 詳細モード
        $routeFlag = 1;// view表示の振り分け
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // 検索キー
        $personEdits = $request->all();
        $personCode = $personEdits['editSearch'];
        // 一覧からデータ取得
        $person = $M_Person->Person($tenantCode,$tenantBranch,$personCode);
        $AuthorityCode = $person['AuthorityCode'];
        // M_Authorityテーブルの存在チェック あればデータ取得
        $AuthorityCheck = $M_Authority->AuthorityCheck($tenantCode,$tenantBranch,$AuthorityCode);
      
        if($AuthorityCheck != null){
            // 編集のAuthorityCodeから登録中のデータを絞り込みセレクトボックスに表示する。
            $authoritySelect = $M_Person->AuthoritySelect($tenantCode,$tenantBranch,$person);
            $authorityName = $authoritySelect['AuthorityName'];
        }else{
            $authorityName = '権限が削除されています。別の権限に変更して下さい。';
        }
        
        return view(
            'Person.Person_create', compact('person','routeFlag','authorityName')
        );
    }

    public function Person_store(PersonRequest $request){
        // 使用するモデル
        $M_Person = new M_Person;
        $M_Authority = new M_Authority;
        $personInputs = $request->all();
        $routeFlag = $request->session()->get('routeFlag');
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;

        // 新規作成＋コピーの時は存在チェック
        if (( $routeFlag === 0 || $routeFlag === 3 ) && M_Person::where('TenantCode', $tenantCode)
        ->where('TenantBranch', $tenantBranch)
        ->where('personCode', $personInputs['PersonCode'])
        ->exists()){
            \Session::forget('routeFlag');
            \Session::flash('err_msg' , '既に担当者コードが使用されています。');
            return redirect()->route('Person.Person_create');
        }else{
            // クリエイトorアップデート
            $M_Person->updateCreate($tenantCode,$tenantBranch,$personInputs);
            // AuthorityCodeとNameを紐づけて表示
            $persons = $M_Person->AuthorityName($tenantCode,$tenantBranch);
            return view(
                'Person.Person_index' ,compact('persons')
            );
        }
    }
    
    public function Person_edit(Request $request){
        // 使用するモデル
        $M_Person = new M_Person;
        // 検索キー
        $personEdits = $request->all();
        $personCode = $personEdits['editSearch'];
        
        if(!empty($personEdits['copyFlag'])){
            $copyFlag = intval($personEdits['copyFlag']);
            if($copyFlag === 1){
                // コピーモード
                \Session::put(['routeFlag' => 3]);// DB更新時の振り分け
            }else{
                // 編集モード
                \Session::put(['routeFlag' => 2]);// DB更新時の振り分け
            }
        }else{
            // 編集モード
            \Session::put(['routeFlag' => 2]);// DB更新時の振り分け
        }
        
        $routeFlag = $request->session()->get('routeFlag');// view表示の振り分け
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // 存在チェック あればデータ取得
        $PersonDateCheck = $M_Person->PersonDateCheck($tenantCode,$tenantBranch,$personCode);
        if($PersonDateCheck !== null)
        {
            // 一覧からデータ取得
            $person = $M_Person->Person($tenantCode,$tenantBranch,$personCode);
            // 編集のAuthorityCodeから登録中のデータを絞り込みセレクトボックスに表示する。
            $authoritySelect = $M_Person->AuthoritySelect($tenantCode,$tenantBranch,$person);
            $authorityName = $authoritySelect['AuthorityName'];
            // セレクトボックスに登録されている権限を表示する
            $authoritys = M_Authority::orderBy('AuthorityCode', 'asc')->get();
            return view(
                'Person.Person_create', compact('person','routeFlag','authoritys','authorityName')
            );
        }else{
            \Session::forget('routeFlag');
            \Session::flash('err_msg' , '担当者コードが存在していません。');
            return redirect()->route('Person.Person_create');
        }   
    }

    // 削除
    public function Person_destroy(Request $request)
    {
        // 使用するモデル
        $M_Person = new M_Person;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // 検索キー
        $personDeletes = $request->all();
        $personCode = $personDeletes['deleteSearch'];
        // 存在チェック あればデータ取得
        $PersonDateCheck = $M_Person->PersonDateCheck($tenantCode,$tenantBranch,$personCode);
        if($PersonDateCheck !== null)
        {
            // 削除ロジック
            $M_Person->PersonDelete($tenantCode,$tenantBranch,$personCode);
            // AuthorityCodeとNameを紐づけて表示
            $persons = $M_Person->AuthorityName($tenantCode,$tenantBranch);
            return redirect()->route('Person.Person_index')->with(compact('persons'));
        }else{
            \Session::forget('routeFlg');
            \Session::flash('err_msg' , '担当者コードが存在していません。');
            return redirect()->route('Person.Person_create');
        }
    }

    // コピー フラグ立ててif文でセッション入れれば良かった。。。
    public function Person_copy(Request $request){
        // 使用するモデル
        $M_Person = new M_Person;
        // 詳細モード
        $routeFlag = 1;// view表示の振り分け
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // 検索キー
        $personCopy = $request->all();
        $personCode = $personCopy['copySearch'];
       

        // 存在チェック あればデータ取得
        $PersonDateCheck = $M_Person->PersonDateCheck($tenantCode,$tenantBranch,$personCode);
        if($PersonDateCheck !== null)
        {
            // 一覧からデータ取得
            $person = $M_Person->Person($tenantCode,$tenantBranch,$personCode);

            // 存在チェック あればデータ取得
            $authoritySelect = $M_Person->AuthoritySelect($tenantCode,$tenantBranch,$person);
            if($authoritySelect !== null)
            {
                // 編集のAuthorityCodeから登録中のデータを絞り込みセレクトボックスに表示する。
                $authoritySelect = $M_Person->AuthoritySelect($tenantCode,$tenantBranch,$person);
                $authorityName = $authoritySelect['AuthorityName'];
            }else{
                \Session::forget('routeFlg');
                \Session::flash('err_msg' , '権限が削除されています。別の権限に変更して下さい。');
                return redirect()->route('Person.Person_create');
            }

            // コピーしたデータをセッションに保存
            $M_Person->CopySession($request,$person);

            \Session::flash('err_msg' , 'コピーしました。');
            return view(
                'Person.Person_create', compact('person','routeFlag','authorityName')
            );

        }else{
            \Session::forget('routeFlg');
            \Session::flash('err_msg' , '担当者コードが存在していません。');
            return redirect()->route('Person.Person_create');
        }
    }


    public function Person_paste(Request $request){

        // 使用するモデル
        $M_Person = new M_Person;

        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // セレクトボックスに登録されている権限を表示する
        $authoritys = M_Authority::orderBy('AuthorityCode', 'asc')->get();
        // コピーモード
        \Session::put(['routeFlag' => 3]);// DB更新時の振り分け
        $routeFlag = $request->session()->get('routeFlag');// view表示の振り分け
        $person = $request->session()->get('formCopy');

        if($person == null){
            \Session::flash('err_msg' , 'データがありません。コピーしてください。');
       
            return redirect( route('Person.Person_create') )->withInput();;
            // return view(
            //     'Person.Person_create' ,compact('authoritys')
            // );
        }

        // 存在チェック あればデータ取得
        $authoritySelect = $M_Person->AuthoritySelect($tenantCode,$tenantBranch,$person);
        if($authoritySelect !== null)
        {
            // 編集のAuthorityCodeから登録中のデータを絞り込みセレクトボックスに表示する。
            $authoritySelect = $M_Person->AuthoritySelect($tenantCode,$tenantBranch,$person);
            $authorityName = $authoritySelect['AuthorityName'];
            \Session::flash('err_msg' , '貼り付けました。');
            return view(
                'Person.Person_create' ,compact('person','routeFlag','authoritys','authorityName')
            );
        }else{
            \Session::flash('err_msg' , 'データがありません。コピーしてください。');
            return view(
                'Person.Person_create' ,compact('authoritys')
            );
        }
    }



}
