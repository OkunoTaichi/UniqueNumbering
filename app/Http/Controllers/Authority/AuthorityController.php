<?php

namespace App\Http\Controllers\Authority;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Authority\M_Authority;
use App\Models\Authority\M_AuthorityDetail;
use App\Models\Authority\M_Program;
use App\Models\M_Division;
use DB;

class AuthorityController extends Controller
{
    public function authority_index()
    {
        $authoritys = M_Authority::get();
        $programs = M_Program::get();
        $AuthorityDivs = M_Division::where('DivCode','AuthorityDiv')
        ->select('DivCode','DivNo','DivName')
        ->get();
        
        $routeFlg = 1;

        // システム管理者チェックボックスissetエラー対策
        $AdminFlg = null;
       
        // dd($AuthorityDivs[0]->DivNo);
        return view(
            'Authority.Authority_index', compact('authoritys','programs','AuthorityDivs','AdminFlg','routeFlg')
        );
    }

    public function authority_store(Request $request)
    {
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;

        $authorityInputs = $request->all();
        // AuthorityDetailは全てのプログラムを同時にstoreするのでProgramIDの数だけfor文で回す
        $programs = $request->only('ProgramID');
        $count = count($programs['ProgramID']);

       
        
        DB::beginTransaction();
        try{

            // クリエイトだけVer
            // M_Authority::create(
            // [
            //     "TenantCode" => $tenantCode,
            //     "TenantBranch" => $tenantBranch,
            //     "AuthorityCode" => $authorityInputs['AuthorityCode'],
            //     "AuthorityName" => $authorityInputs['AuthorityName'],
            //     "AdminFlg" => $authorityInputs['AdminFlg'],
            //     // "UpdatePerson" => ,
            // ]);

            M_Authority::updateOrCreate(
                [
                    "TenantCode" => $tenantCode,
                    "TenantBranch" => $tenantBranch,
                    "AuthorityCode" => $authorityInputs['AuthorityCode']
                ],
                [
                    "TenantCode" => $tenantCode,
                    "TenantBranch" => $tenantBranch,
                    "AuthorityCode" => $authorityInputs['AuthorityCode'],
                    "AuthorityName" => $authorityInputs['AuthorityName'],
                    "AdminFlg" => $authorityInputs['AdminFlg'],
                    // "UpdatePerson" => ,
                ]);



            // updateOrCreateだとプライマーキー関連の処理がかなりめんどくさい（idなど主キーがあればOK。今回はテーブルにないので複合キー作成⇒使用許可にHasCompositePrimaryKeyTrait挟む必要がある。）
            // for文でプログラムの数だけクエリを発行する（プログラム数が多くなると負荷がかかる）
            for ($i=0; $i<$count; $i++){
          
                M_AuthorityDetail::updateOrCreate(
                    [
                        "TenantCode" => $tenantCode,
                        "TenantBranch" => $tenantBranch,
                        "AuthorityCode" => $authorityInputs['AuthorityCode'],
                        "ProgramID" => $authorityInputs['ProgramID'][$i]
                    ],
                    [
                        "TenantCode" => $tenantCode,
                        "TenantBranch" => $tenantBranch,
                        "AuthorityCode" => $authorityInputs['AuthorityCode'],
                        "ProgramID" => $authorityInputs['ProgramID'][$i],
                        "AuthorityDiv" => $authorityInputs['AuthorityDiv'][$i],
                    ]
                );
            }

            // for文でプログラムの数だけクエリを発行する（プログラム数が多くなると負荷がかかる）クリエイトだけVer
            // for ($i=0; $i<$count; $i++){
            //     $detailInputs = [
            //         "TenantCode" => $tenantCode,
            //         "TenantBranch" => $tenantBranch,
            //         "AuthorityCode" => $authorityInputs['AuthorityCode'],
            //         "ProgramID" => $authorityInputs['ProgramID'][$i],
            //         "AuthorityDiv" => $authorityInputs['AuthorityDiv'][$i],
            //     ];
            //     M_AuthorityDetail::create($detailInputs);
            // }
          
            DB::commit();

        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
        }
       
        \Session::flash('err_msg' , '登録しました。');

        return redirect( route('Authority.Authority_index') );
    }

    public function authority_edit(Request $request){

        // 初期データ（インスタンス化する必要がある）
        $authoritys = M_Authority::get();
        $programs = M_Program::get();
        $AuthorityDivs = M_Division::where('DivCode','AuthorityDiv')
        ->select('DivCode','DivNo','DivName')
        ->get();

        // ボタンの色
        $routeFlg = 2;

        // テナントコードの読み込み
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;

        // 検索キー
        $authorityEdits = $request->all();
        $AuthorityCode = $authorityEdits['editSearch'];
        // dd($AuthorityCode);

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
     
        // dd($AuthorityDetail[0]['AuthorityDiv']);

        return view(
            'Authority.Authority_index', compact('authoritys','programs','AuthorityDivs','Authority','AuthorityDetail','AdminFlg','routeFlg')
        );

    }

    // 削除
    public function authority_destroy(Request $request)
    {
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
        $authorityDeletes = $request->all();
        // dd($authorityDeletes);
        $AuthorityCode = $authorityDeletes['deleteSearch'];
     
        // ボタンの色
        $routeFlg = 1;
        // システム管理者チェックボックスissetエラー対策
        $AdminFlg = null;

       



        \DB::beginTransaction();
        try{

            M_Authority::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->where('AuthorityCode', $AuthorityCode)
            ->delete();

            M_AuthorityDetail::where('TenantCode', $tenantCode)
            ->where('TenantBranch', $tenantBranch)
            ->where('AuthorityCode', $AuthorityCode)
            ->delete();

            \DB::commit();     
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , '削除をしました。');


        // 削除後に再度DBのデータ取得（しないと削除前のデータをコンパクトする）
        $authoritys = M_Authority::get();



        
       
        // dd($AuthorityDivs[0]->DivNo);
        return view(
            'Authority.Authority_index', compact('authoritys','programs','AuthorityDivs','AdminFlg','routeFlg')
        );
      



       




        // if (M_Numbering::where('id', $inputs['id'])->exists() !== false){

        //     \DB::beginTransaction();
        //     try{
        //         M_Numbering::where('id', $inputs['id'])->delete();
        //         \DB::commit();     
        //     }catch(\Throwable $e){
        //         \DB::rollback();
        //         abort(500);
        //     }
        //     \Session::flash('err_msg' , '削除をしました。');
        //     return redirect( route('home') );

        // }else{

        //     \Session::flash('err_msg' , 'データが存在しません。');
        //     return redirect( route('home') );
        // }
    }
}
