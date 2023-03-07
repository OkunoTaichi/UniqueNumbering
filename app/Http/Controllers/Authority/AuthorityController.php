<?php

namespace App\Http\Controllers\Authority;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Authority\AuthorityRequest;

use App\Models\Authority\M_Authority;
use App\Models\Authority\M_AuthorityDetail;
use App\Models\Authority\M_Program;
use App\Models\Person\M_Person;
use App\Models\M_Division;
use DB;

class AuthorityController extends Controller
{
    public function authority_index()
    {
        // session()->forget('formCopy');
        // 使用するモデル
        $M_Authority = new M_Authority;
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // DBのデータ取得
        $authoritys = $M_Authority->AuthorityReload($tenantCode,$tenantBranch);
        $programs = M_Program::get();
        // ラジオボタンの表示と出力値
        $AuthorityDivs = $M_Authority->RadioOutput();
        $routeFlg = 1;
        \Session::put(['routeFlg' => 1]);
        // システム管理者チェックボックスissetエラー対策
        $AdminFlg = null;
       
        return view(
            'Authority.Authority_index', compact('authoritys','programs','AuthorityDivs','AdminFlg','routeFlg')
        );
    }

    public function authority_store(AuthorityRequest $request)
    {
        $routeFlg = $request->session()->get('routeFlg');
        // 使用するモデル
        $M_Authority = new M_Authority;

        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        $authorityInputs = $request->all();

        // ラジオボタンに全てチェックしていないときの処理
        if(!isset($authorityInputs['AuthorityDiv'])){
            \Session::flash('err_msg' , 'プログラムの設定は全て必須です。');
            return redirect( route('Authority.Authority_index') )->withInput();
        }else{
            $countAuthority = count($authorityInputs['AuthorityDiv']);
        }

        $programs = $request->only('ProgramID');
        $count = count($programs['ProgramID']);

        // プログラムが追加されたときにキーを追加する数（プログラムー登録数）
        $keyAdd = $count-$countAuthority;

        // 登録数よりプログラム数が多い場合は「null」でキーを追加する。
        if(0<$keyAdd){
            for ($i=0; $i<$keyAdd; $i++){
                array_push($authorityInputs['AuthorityDiv'], null);
            }
        }
        if (in_array(null, $authorityInputs['AuthorityDiv'], true)) {
            \Session::flash('err_msg' , 'プログラムの設定は全て必須です。');
            return redirect( route('Authority.Authority_index') )->withInput();
        } 

        // 新規作成＋コピーの時は存在チェック
        if (( $routeFlg === 1 || $routeFlg === 4 ) && M_Authority::where('TenantCode', $tenantCode)
        ->where('TenantBranch', $tenantBranch)
        ->where('AuthorityCode', $authorityInputs['AuthorityCode'])
        ->exists()){
            \Session::flash('err_msg' , '権限CDが存在しています。');

        }else{
            // クリエイト+アップデートVer
            $M_Authority->updateCreate($tenantCode,$tenantBranch,$authorityInputs,$count);
        }
            
        return redirect( route('Authority.Authority_index') )->withInput();
    }


    public function authority_edit(Request $request){
        // セッションデータ初期化
        \Session::flash('err_msg' , '');
        // 使用するモデル
        $M_Authority = new M_Authority;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // DBのデータ取得
        $authoritys = $M_Authority->AuthorityReload($tenantCode,$tenantBranch);
        $programs = M_Program::get();
        // ラジオボタンの表示と出力値
        $AuthorityDivs = $M_Authority->RadioOutput();
        // 検索キー
        $authorityEdits = $request->all();
        $AuthorityCode = $authorityEdits['editSearch'];
        // 表示とかのフラグ(編集モード)
        if(isset($authorityEdits['editFlag'])){
            $editFlag = $authorityEdits['editFlag'];
        }else{
            $editFlag = null;
        }
        // 表示とかのフラグ(コピーモード)
        if(isset($authorityEdits['copyFlag'])){
            $copyFlag = $authorityEdits['copyFlag'];
        }else{
            $copyFlag = null;
        }
        // M_Authorityテーブルの存在チェック あればデータ取得
        $AuthorityCheck = $M_Authority->AuthorityCheck($tenantCode,$tenantBranch,$AuthorityCode);
        if($AuthorityCheck != null){
            // 検索キーから上段のインプット欄に出力するデータ取得
            $Authority = $M_Authority->AuthorityCheck($tenantCode,$tenantBranch,$AuthorityCode);
            $AdminFlg = $Authority['AdminFlg'];
            // ラジオボタンのデータ取得
            $AuthorityDetail = $M_Authority->RadioInput($tenantCode,$tenantBranch,$AuthorityCode);
            // ボタンの色とかの振り分け
            if($editFlag == 3){
                \Session::put(['routeFlg' => 3]);
            }elseif($copyFlag == 4){
                \Session::put(['routeFlg' => 4]);
            }else{
                \Session::put(['routeFlg' => 2]);
            }
            $routeFlg = $request->session()->get('routeFlg');
            
            return view(
                'Authority.Authority_index', compact('authoritys','programs','AuthorityDivs','Authority','AuthorityDetail','AdminFlg','routeFlg')
            );
        }else{
            // ボタンの色とかの振り分け
            $AdminFlg = 0;
            \Session::put(['routeFlg' => 1]);
            $routeFlg = $request->session()->get('routeFlg');
            \Session::flash('err_msg' , '権限CDが存在していません。');
            return redirect()->route('Authority.Authority_index')->with(compact('authoritys','programs','AuthorityDivs','routeFlg','AdminFlg'));
        }
    }

    // 削除
    public function authority_destroy(Request $request)
    {
        // 使用するモデル
        $M_Authority = new M_Authority;
        // 初期データ
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // DBのデータ取得
        $authoritys = $M_Authority->AuthorityReload($tenantCode,$tenantBranch);
        $programs = M_Program::get();
        // ラジオボタンの表示と出力値
        $AuthorityDivs = $M_Authority->RadioOutput();
        // 検索キー
        $authorityDeletes = $request->all();
        $AuthorityCode = $authorityDeletes['deleteSearch'];
        // ボタンの色
        $routeFlg = 1;
        // システム管理者チェックボックスissetエラー対策
        $AdminFlg = null;

        // 削除前の権限使用しているかチェック
        $PersonCheck = $M_Authority->PersonCheck($tenantCode,$tenantBranch,$AuthorityCode);
        if($PersonCheck == null)
        {
            // M_Authorityテーブルの存在チェック あればデータ取得
            $AuthorityCheck = $M_Authority->AuthorityCheck($tenantCode,$tenantBranch,$AuthorityCode);
            if($AuthorityCheck != null)
            {
                // 削除ロジック
                $M_Authority->authorityDelete($tenantCode,$tenantBranch,$AuthorityCode);
            }else{
                \Session::flash('err_msg' , '権限CDが存在していません。');
            }
            // 削除後に再度DBのデータ取得（しないと削除前のデータをコンパクトする）
            $authoritys = $M_Authority->AuthorityReload($tenantCode,$tenantBranch);
            return redirect()->route('Authority.Authority_index')->with(compact('authoritys','programs','AuthorityDivs','AdminFlg','routeFlg'));
                
        }else{
            \Session::flash('err_msg' , '権限CDが使用されています。先に変更して下さい。');
            return redirect()->route('Authority.Authority_index')->with(compact('authoritys','programs','AuthorityDivs','AdminFlg','routeFlg'));
        }
    }


    // コピー
    public function authority_copy(Request $request){
        // 使用するモデル
        $M_Authority = new M_Authority;

        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // DBのデータ取得
        $authoritys = $M_Authority->AuthorityReload($tenantCode,$tenantBranch);
        $programs = M_Program::get();
        // ラジオボタンの表示と出力値
        $AuthorityDivs = $M_Authority->RadioOutput();
        // 検索キー
        $AuthorityCopy = $request->all();
        $AuthorityCode = $AuthorityCopy['copySearch'];
        // M_Authorityテーブルの存在チェック あればデータ取得
        $AuthorityCheck = $M_Authority->AuthorityCheck($tenantCode,$tenantBranch,$AuthorityCode);
        if($AuthorityCheck != null)
        {
            // 検索キーからコピーするデータ取得
            $Authority = $AuthorityCheck;
            $AdminFlg = $Authority['AdminFlg'];
            // ラジオボタンのデータ取得
            $AuthorityDetail = $M_Authority->RadioInput($tenantCode,$tenantBranch,$AuthorityCode);
            // コピーしたデータをセッションに保存
            $request->session()->forget('formCopy');
            $request->session()->put('formCopy', [
                'AuthorityCode' => $Authority['AuthorityCode'],
                'AuthorityName' => $Authority['AuthorityName'],
                'AdminFlg' => $Authority['AdminFlg'],
            ]);
            // コピーモード
            \Session::put(['routeFlg' => 2]);// DB更新時の振り分け
            // コピー中のフラグ あんまりよくない数値がかぶるとエラーになるので修正要
            \Session::put(['pasteFlag' => 2]);
            $routeFlg = $request->session()->get('routeFlg');
            \Session::flash('err_msg' , 'コピーしました。');
            return view(
                'Authority.Authority_index', compact('authoritys','programs','AuthorityDivs','Authority','AuthorityDetail','AdminFlg','routeFlg')
            );
        }else{
            \Session::forget('routeFlg');
            \Session::flash('err_msg' , '担当者コードが存在していません。');
            return redirect()->route('Authority.Authority_index');
        }
    }


    public function authority_paste(Request $request){
        // 使用するモデル
        $M_Authority = new M_Authority;
        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // DBのデータ取得
        $authoritys = $M_Authority->AuthorityReload($tenantCode,$tenantBranch);
        $programs = M_Program::get();
        // ラジオボタンの表示と出力値
        $AuthorityDivs = $M_Authority->RadioOutput();

        $Authority = $request->session()->get('formCopy');
   
        if($Authority == null){
            $AdminFlg = null;
            // コピーモード
            \Session::put(['routeFlg' => 1]);// DB更新時の振り分け
            $routeFlg = $request->session()->get('routeFlg');
            \Session::flash('err_msg' , 'データがありません。コピーしてください。');
       
            return view(
                'Authority.Authority_index', compact('authoritys','Authority','programs','AuthorityDivs','routeFlg','AdminFlg')
            );
        }
        $AuthorityCode = $Authority['AuthorityCode'];
        $AdminFlg = $Authority['AdminFlg'];
       

        // M_Authorityテーブルの存在チェック あればデータ取得
        $AuthorityCheck = $M_Authority->AuthorityCheck($tenantCode,$tenantBranch,$AuthorityCode);
        if($AuthorityCheck != null){
            // コピーモード
            \Session::put(['routeFlg' => 4]);// DB更新時の振り分け
            $routeFlg = $request->session()->get('routeFlg');
            // ラジオボタンのデータ取得
            $AuthorityDetail = $M_Authority->RadioInput($tenantCode,$tenantBranch,$AuthorityCode);
            \Session::flash('err_msg' , '貼り付けました。');
            return view(
                'Authority.Authority_index', compact('authoritys','Authority','programs','AuthorityDivs','AuthorityDetail','AdminFlg','routeFlg')
            );
        }else{
            // コピーモード
            \Session::put(['routeFlg' => 1]);// DB更新時の振り分け
            $routeFlg = $request->session()->get('routeFlg');
            \Session::flash('err_msg' , 'データが存在しません。');
            return view(
                'Authority.Authority_index', compact('authoritys','Authority','programs','AuthorityDivs','AdminFlg','routeFlg')
            );
        }
    }






}

