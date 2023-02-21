<?php

namespace App\Http\Controllers\Authority;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Authority\AuthorityRequest;

use App\Models\Authority\M_Authority;
use App\Models\Authority\M_AuthorityDetail;
use App\Models\Authority\M_Program;
use App\Models\M_Division;
use DB;

class AuthorityController extends Controller
{
    public function authority_index()
    {
        // セッションデータ初期化
        // \Session::flash('err_msg' , '');

        $authoritys = M_Authority::get();
        $programs = M_Program::get();
        $AuthorityDivs = M_Division::where('DivCode','AuthorityDiv')
        ->select('DivCode','DivNo','DivName')
        ->get();
        
        // この辺のセッション関係修正要
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
        // dd($routeFlg);
        // 使用するモデル
        $M_Authority = new M_Authority;

        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;

        $authorityInputs = $request->all();
        // AuthorityDetailは全てのプログラムを同時にstoreするのでProgramIDの数だけfor文で回す
        $programs = $request->only('ProgramID');
        $count = count($programs['ProgramID']);

        // クリエイトだけVer
        // $M_Authority->createOnly($tenantCode,$tenantBranch,$authorityInputs);

        // 新規作成＋コピーの時は存在チェック
        if (( $routeFlg === 1 || $routeFlg === 4 )&& M_Authority::where('TenantCode', $tenantCode)
        ->where('TenantBranch', $tenantBranch)
        ->where('AuthorityCode', $authorityInputs['AuthorityCode'])
        ->exists()){
            \Session::flash('err_msg' , '権限CDが存在しています。');

        }else{
            // クリエイト+アップデートVer
            $M_Authority->updateCreate($tenantCode,$tenantBranch,$authorityInputs,$count);
        }
            
        return redirect( route('Authority.Authority_index') );
    }


    public function authority_edit(Request $request){
        // セッションデータ初期化
        \Session::flash('err_msg' , '');

        // 初期データ（インスタンス化する必要がある）
        $authoritys = M_Authority::get();
        $programs = M_Program::get();
        $AuthorityDivs = M_Division::where('DivCode','AuthorityDiv')
        ->select('DivCode','DivNo','DivName')
        ->get();


        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;

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

        // 存在チェック あればデータ取得
        if ( M_Authority::where('TenantCode', $tenantCode)
        ->where('TenantBranch', $tenantBranch)
        ->where('AuthorityCode', $AuthorityCode)
        ->exists()){

            // 検索キーから上段のインプット欄に出力するデータ取得
            $Authority = M_Authority::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->where('AuthorityCode', $AuthorityCode)
            ->first();

            $AdminFlg = $Authority['AdminFlg'];

            // 検索キーから下段のインプット欄＋ラジオボタンに出力するデータ取得
            $AuthorityDetail = M_AuthorityDetail::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->where('AuthorityCode', $AuthorityCode)
            ->get();

            // ボタンの色とかの振り分け
            if($editFlag == 3){
                \Session::put(['routeFlg' => 3]);
            }elseif($copyFlag == 4){
                \Session::put(['routeFlg' => 4]);
            }else{
                \Session::put(['routeFlg' => 2]);
            }
            $routeFlg = $request->session()->get('routeFlg');
            // dd($routeFlg);

            
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
            // return view(
            //     'Authority.Authority_index', compact('authoritys','programs','AuthorityDivs','routeFlg','AdminFlg')
            // );
        }

        

        

    }

    // 削除
    public function authority_destroy(Request $request)
    {
        // 使用するモデル
        $M_Authority = new M_Authority;
        // 初期データ
        $authoritys = M_Authority::get();
        $programs = M_Program::get();
        $AuthorityDivs = M_Division::where('DivCode','AuthorityDiv')
        ->select('DivCode','DivNo','DivName')
        ->get();

        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;

        // 検索キー
        $authorityDeletes = $request->all();
        // dd($authorityDeletes);
        $AuthorityCode = $authorityDeletes['deleteSearch'];
     
        // ボタンの色
        $routeFlg = 1;
        // システム管理者チェックボックスissetエラー対策
        $AdminFlg = null;

        
        // 存在チェック あればデータ取得
        if ( M_Authority::where('TenantCode', $tenantCode)
        ->where('TenantBranch', $tenantBranch)
        ->where('AuthorityCode', $AuthorityCode)
        ->exists()){

            // 削除ロジック
            $M_Authority->authorityDelete($tenantCode,$tenantBranch,$AuthorityCode);
        }else{
            \Session::flash('err_msg' , '権限CDが存在していません。');
        }

        // 削除後に再度DBのデータ取得（しないと削除前のデータをコンパクトする）
        $authoritys = M_Authority::get();

        return redirect()->route('Authority.Authority_index')->with(compact('authoritys','programs','AuthorityDivs','AdminFlg','routeFlg'));
        // return view(
        //     'Authority.Authority_index', compact('authoritys','programs','AuthorityDivs','AdminFlg','routeFlg')
        // );
    }
}

