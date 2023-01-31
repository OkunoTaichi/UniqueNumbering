<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\UnNumberRequest;
use App\Http\Requests\SearchRequest;
use App\Models\M_Numbering;

use DB;

class EditController extends Controller
{
    // オリジナル編集区分の作成

    public function edit_create()
    {
        $s_edits = DB::table('EditDiv')->get();
        $s_dates = DB::table('DateDiv')->get();
        $s_numbers = DB::table('NumberDiv')->get();
        $s_tenants = DB::table('m_tenant')->get();
        $s_tenantBranchs = DB::table('m_tenantbranch')->get();
        // dd( $s_tenants);
        return view(
            'UnNumber.edit_create', compact('s_edits','s_dates','s_numbers', 's_tenants','s_tenantBranchs')
        );
    }

    public function edit_confirm(Request $request)
    {
        $inputs = $request->all();
        

        //入力された値から紐づいている行を取得し、nameカラムを格納する。
        $t_edit = DB::table('EditDiv')->where('edit_id', $inputs['editdiv'])->first();
        $t_date = DB::table('DateDiv')->where('date_id', $inputs['datediv'])->first();
        $t_number = DB::table('NumberDiv')->where('number_id', $inputs['numberdiv'])->first();

        $t_tenant = DB::table('m_tenant')->where('TenantCode', $inputs['TenantCode'])->first();
        $t_tenantBranch = DB::table('m_tenantbranch')->where('TenantBranch', $inputs['TenantBranch'])->first();

        // dd($t_tenant,$t_tenantBranch);
        return view(
            'UnNumber.edit_confirm',compact('inputs','t_edit', 't_date','t_number', 't_tenant','t_tenantBranch')
        ); 
    }

    public function edit_store(Request $request)
    {
        $UnNumberInputs = $request->all();
        // dd($UnNumberInputs);

        // データを登録
        DB::beginTransaction();
        try{
            M_Numbering::create($UnNumberInputs);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , '登録しました。');
        return redirect( route('home') );
    }
}
