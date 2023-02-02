<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SystemRequest;
use App\Models\System;
use App\Models\T_NumberInfo;
use App\Models\M_Numbering;

use DB;

class SystemController extends Controller
{
    public function system_index()
    {
        $s_tenantbranchs = DB::table('m_tenantbranch')->get();
        $s_tenants = DB::table('m_tenant')->get();
        return view(
            'UnNumber.system_index', compact('s_tenants', 's_tenantbranchs')
        );
    }

    public function system_create(SystemRequest $request)
    {
        // ➀ 採番区分特定の処理 
        $inputs = $request->all();
  
        $searchId = $request->input('searchId');
        $searchId_2 = $request->input('searchId_2');
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
            return view(
                'UnNumber.system_index', compact('s_tenants', 's_tenantbranchs')
            );
        }
      
        // T_NumberInfoテーブルにデータが存在するかチェック（存在すれば更新処理）
        $countNumbers = T_NumberInfo::where('TenantCode',$searchId)
            ->where('TenantBranch',$searchId_2)
            ->where('NumberDiv',$searchId_3)
            ->first();
  
        if($countNumbers != null){
            $update_id = $countNumbers->id;// DB登録のID
        }else{
            $update_id = null;
        }
        
        
        // 使用するモデル
        $System = new System;

        // ➀ セレクトボックスで選択されたテナントコードとテナントブランチを元にm_numberingテーブルから該当のデータを絞込み
        $edit = $System->editSearch($searchId,$searchId_2,$searchId_3);

        // ➁ 採番するIDの処理 * $change_number 最後DBに更新
        $change_number = $System->numberSearch($countNumbers,$edit);
        
        // ➂ 編集区分によって採番するパターンを変更する処理
        $reserve_id = $System->division($edit, $change_number, $dateTime);
        
        // ➃ 予約確定 バージョン 予約完了画面に移動
        $System->update_create($edit, $reserve_id, $change_number,$update_id);
        // $request->session()->regenerateToken();

        return view(
            'UnNumber.system_create',  compact('edit','reserve_id')
        );

        
    }
}
