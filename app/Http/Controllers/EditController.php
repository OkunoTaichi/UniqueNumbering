<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\EditRequest;
use App\Models\M_Numbering;
use App\Models\M_Division;


use DB;

class EditController extends Controller
{
    // オリジナル編集区分の作成

    public function edit_create()
    {
        
        $s_numbers = M_Division::where('DivCode','NumberDiv')->get();
        $s_edits = M_Division::where('DivCode','EditDiv')->get();
        $s_dates = M_Division::where('DivCode','DateDiv')->get();
        $s_tenants = DB::table('m_tenant')->get();
        $s_tenantBranchs = DB::table('m_tenantbranch')->get();
        return view(
            'UnNumber.edit_create', compact('s_edits','s_dates','s_numbers', 's_tenants','s_tenantBranchs')
        );
    }

    public function edit_confirm(EditRequest $request)
    {
        $inputs = $request->all();

        if($inputs['editdiv'] == "1" || $inputs['editdiv'] == "4"){
            $lengs = 15;
        }elseif($inputs['editdiv'] == "2" || $inputs['editdiv'] == "5"){
            $lengs = 7;
        }elseif($inputs['editdiv'] == "3"){
            $lengs = 6;
        };
        

        // コード＋ブランチ->採番区分が使われているかのチェックの処理(DB:t_number_info)
        $M_NumberInfo = M_Numbering::where('TenantCode',$inputs['TenantCode'])
        ->where('TenantBranch',$inputs['TenantBranch'])
        ->where('NumberDiv',$inputs['numberdiv'])
        ->first();

        // dd($M_NumberInfo);

        if($M_NumberInfo != null ){
            \Session::flash('err_msg' , '採番区分が既に使用されています。');
            return back()->withInput(); 
        }

        //入力された値から紐づいている行を取得し、nameカラムを格納する。
        $t_number = M_Division::where('DivCode','NumberDiv')->where('DivNo', $inputs['numberdiv'])->first();
        $t_edit = M_Division::where('DivCode','EditDiv')->where('DivNo', $inputs['editdiv'])->first();
        $t_date = M_Division::where('DivCode','DateDiv')->where('DivNo', $inputs['datediv'])->first();
        $t_tenant = DB::table('m_tenant')->where('TenantCode', $inputs['TenantCode'])->first();
        $t_tenantBranch = DB::table('m_tenantbranch')->where('TenantBranch', $inputs['TenantBranch'])->first();

        // dd($lengs);
        return view(
            'UnNumber.edit_confirm',compact('inputs','t_edit', 't_date','t_number', 't_tenant','t_tenantBranch','lengs')
        ); 
    }

    public function edit_store(EditRequest $request)
    {
        $UnNumberInputs = $request->all();

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

    // 編集
    public function edit_edit($id)
    {
        $input = M_Numbering::find($id); 
        $get_numbers = M_Division::where('DivCode','NumberDiv')
        ->where('DivNo',$input['numberdiv'])->first();
        $s_edits = M_Division::where('DivCode','EditDiv')
        ->get();
        $get_edits = M_Division::where('DivCode','EditDiv')
        ->where('DivNo',$input['editdiv'])->first();
        $s_dates = M_Division::where('DivCode','DateDiv')
        ->get();
        $get_dates = M_Division::where('DivCode','DateDiv')
        ->where('DivNo',$input['datediv'])->first();
       
        if(is_null($input)){
            \Session::flash('err_msg' , 'データがありません。');
            return redirect( route('home') );
        }
        return view('UnNumber.edit_edit', 
        compact(
            'input','get_numbers',
            's_edits','get_edits',
            's_dates','get_dates',
        ));
    }

    // 更新
    public function edit_update(Request $request)
    {
        $inputs = $request->all();

        if($inputs['editdiv'] == "1" || $inputs['editdiv'] == "4"){
            $lengs = 15;
        }elseif($inputs['editdiv'] == "2" || $inputs['editdiv'] == "5"){
            $lengs = 7;
        }elseif($inputs['editdiv'] == "3"){
            $lengs = 6;
        };

        // 記号が不要の項目の場合は入力欄を空にする（暫定対策）
        $symbol = $inputs['symbol'];
        if($inputs['editdiv'] == "1" || $inputs['editdiv'] == "2" || $inputs['editdiv'] == "3"){
            $symbol = null;
        }
    
        DB::beginTransaction();
        try{
            $input = M_Numbering::find($inputs['id']);

            $input->fill([
                'TenantCode' => $inputs['TenantCode'],
                'TenantBranch' => $inputs['TenantBranch'],
                'numberdiv' => $inputs['numberdiv'],
                'initNumber' => $inputs['initNumber'],
                'editdiv' => $inputs['editdiv'],
                'symbol' => $symbol,
                'lengs' => $lengs,
                'datediv' => $inputs['datediv'],
            ]);

            DB::commit();
            $input->update();
        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , '更新しました。');
        return redirect( route('home') );
    }



    public function edit_delete(Request $request)
    {
        $inputs = $request->all();
        if (M_Numbering::where('id', $inputs['id'])->exists() !== false){

            \DB::beginTransaction();
            try{
                M_Numbering::where('id', $inputs['id'])->delete();
                \DB::commit();     
            }catch(\Throwable $e){
                \DB::rollback();
                abort(500);
            }
            \Session::flash('err_msg' , '削除をしました。');
            return redirect( route('home') );

        }else{

            \Session::flash('err_msg' , 'データが存在しません。');
            return redirect( route('home') );
        }
    }
}
