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
       
        // dd($AuthorityDivs[0]->DivNo);
        return view(
            'Authority.Authority_index', compact('authoritys','programs','AuthorityDivs')
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
}
