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
        \Session::forget('routeFlg');
        
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;

        $persons = M_Person::orderBy('updated_at', 'desc')->get();
        // dd($person);
       
        return view(
            'Person.Person_index' ,compact('persons')
        );
    }

    public function Person_create()
    {
        // 新規作成モード
        \Session::put(['routeFlag' => 0]);

        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;

        // セレクトボックスに登録されている権限を表示する
        $authoritys = M_Authority::orderBy('AuthorityCode', 'asc')->get();

        $persons = M_Person::orderBy('updated_at', 'desc')->get();
       
        return view(
            'Person.Person_create' ,compact('persons','authoritys',)
        );
    }

    public function Person_detail(Request $request){

        // 詳細モード
        $routeFlag = 1;// view表示の振り分け

        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;

        // 検索キー
        $personEdits = $request->all();
        $personCode = $personEdits['editSearch'];

        // 検索キーから上段のインプット欄に出力するデータ取得
        $person = M_Person::where('TenantCode', $tenantCode)
        ->where('TenantBranch', $tenantBranch)
        ->where('PersonCode', $personCode)
        ->first();

        return view(
            'Person.Person_create', compact('person','routeFlag')
        );
    }

    public function Person_store(PersonRequest $request){

        $personInputs = $request->all();
        $routeFlag = $request->session()->get('routeFlag');

        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
    
        // 使用するモデル
        $M_Person = new M_Person;

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

            // 更新後の一覧データを取得
            $persons = M_Person::orderBy('updated_at', 'desc')->get();
    
            return view(
                'Person.Person_index' ,compact('persons')
            );
        }
    }
    
    public function Person_edit(Request $request){
       
        // 検索キー
        $personEdits = $request->all();
        $personCode = $personEdits['editSearch'];

        // 担当者コードを選択せずに「編集・削除・コピー」を選択した時の処理
        if($personCode === null){
            $persons = M_Person::get();
            \Session::forget('routeFlag');
            \Session::flash('successe_msg' , '担当者コードを選択してください。');
            return redirect()->route('Person.Person_index')->with(compact('persons'));
        }
        
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
        if ( M_Person::where('TenantCode', $tenantCode)
        ->where('TenantBranch', $tenantBranch)
        ->where('PersonCode', $personCode)
        ->exists()){

            // 検索キーから上段のインプット欄に出力するデータ取得
            $person = M_Person::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->where('PersonCode', $personCode)
            ->first();

            // セレクトボックスに登録されている権限を表示する
            $authoritys = M_Authority::orderBy('AuthorityCode', 'asc')->get();
    
            return view(
                'Person.Person_create', compact('person','routeFlag','authoritys')
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
        $PersonDeletes = $request->all();
        $PersonCode = $PersonDeletes['deleteSearch'];

        // 担当者コードを選択せずに「編集・削除・コピー」を選択した時の処理
        if($PersonCode === null){
            $persons = M_Person::get();
            \Session::forget('routeFlag');
            \Session::flash('successe_msg' , '担当者コードを選択してください。');
            return redirect()->route('Person.Person_index')->with(compact('persons'));
        }

        // 存在チェック あればデータ取得
        if ( M_Person::where('TenantCode', $tenantCode)
        ->where('TenantBranch', $tenantBranch)
        ->where('PersonCode', $PersonCode)
        ->exists()){

            // 削除ロジック
            $M_Person->PersonDelete($tenantCode,$tenantBranch,$PersonCode);

            // 更新後の一覧データを取得
            $persons = M_Person::orderBy('updated_at', 'desc')->get();
            return redirect()->route('Person.Person_index')->with(compact('persons'));

        }else{
            
            \Session::forget('routeFlg');

            \Session::flash('err_msg' , '担当者コードが存在していません。');
            return redirect()->route('Person.Person_create');
        }
    }

    public function Person_copy(Request $request){

        // 検索キー
        $personEdits = $request->all();
        $personCode = $personEdits['editSearch'];

        // 担当者コードを選択せずに「編集・削除・コピー」を選択した時の処理
        if($personCode === null){
            $persons = M_Person::get();
            \Session::forget('routeFlag');
            \Session::flash('successe_msg' , '担当者コードを選択してください。');
            return redirect()->route('Person.Person_index')->with(compact('persons'));
        }

    }



}
