<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SystemRequest;
use App\Models\System;
use App\Models\T_NumberInfo;
use App\Models\M_Numbering;
use App\Models\M_Division;

use DB;

class SystemController extends Controller
{
    public function system_index()
    {

        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;

        // M_Numberingに設定があるかの処理
        $M_Divisions = M_Division::where('DivCode','NumberDiv')
            ->select('DivCode','DivNo','DivName')
            ->get();
            // dd($M_Division);
        // dd($tenantCode,$tenantBranch);
        // $s_tenantbranchs = DB::table('m_tenantbranch')->get();
        // $s_tenants = DB::table('m_tenant')->get();
        
        return view(
            'UnNumber.system_index', compact('tenantCode','tenantBranch','M_Divisions')
        );
    }

    public function system_create(Request $request)
    {
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;



        // ➀ 採番区分特定の処理 
        $inputs = $request->all();
        
        $searchId = $request->input('TenantCode');
        $searchId_2 = $request->input('TenantBranch');
        $searchId_3 = intval($request->input('number_id'));
        $dateTime = date('Ymd', strtotime($inputs['date']));
        
        // M_Numberingに設定があるかの処理
        $M_NumberingInfo = M_Numbering::where('TenantCode',$searchId)
        ->where('TenantBranch',$searchId_2)
        ->where('NumberDiv',$searchId_3)
        ->first();
       
        
        if($M_NumberingInfo == null ){
            $s_tenantbranchs = DB::table('m_tenantbranch')->get();
            $s_tenants = DB::table('m_tenant')->get();
            \Session::flash('err_msg' , '設定がありません');
            return back(
               
            );
        }
      
        // T_NumberInfoテーブルにデータが存在するかチェック（存在すれば更新処理）
        $countNumbers = T_NumberInfo::where('TenantCode',$searchId)
            ->where('TenantBranch',$searchId_2)
            ->where('NumberDiv',$searchId_3)
            ->where('NumberDate',$dateTime)
            ->first();
  
        if($countNumbers != null){
            $update_id = $countNumbers->id;// DB登録のID
            $countNumber = $countNumbers->CountNumber + 1;// DB登録のID
        }else{
            $update_id = null;
            $countNumber = 1;
        }
        
    
        
        // 使用するモデル
        $System = new System;

        // ➀ セレクトボックスで選択されたテナントコードとテナントブランチを元にm_numberingテーブルから該当のデータを絞込み
        $edit = $System->editSearch($searchId,$searchId_2,$searchId_3);

        // ➁ 採番する連番の処理
        $initNumber = $edit->initNumber;
        $initNumber = intval($initNumber);
        $countNumber = intval($countNumber);
        $change_number = $System->numberSearch($countNumbers, $countNumber,$initNumber);

        // ➂ 編集区分によって採番するパターンを変更する処理(01処理)
        $reserve_id = $System->divisions($edit, $change_number, $dateTime);
        // ➂ 編集区分によって採番するパターンを変更する処理--ボツ
        // $reserve_id = $System->division($edit, $change_number, $dateTime);
        
        // ➃ 予約確定 バージョン 予約完了画面に移動
        $System->update_create($edit, $reserve_id, $countNumber,$update_id,$dateTime);
        // $request->session()->regenerateToken();

        return view(
            'UnNumber.system_create',  compact('edit','reserve_id','dateTime')
        );

        
    }
}
