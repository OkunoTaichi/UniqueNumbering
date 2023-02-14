<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\EditRequest;
use App\Http\Requests\EditEditRequest;
use App\Models\M_Numbering;
use App\Models\M_Division;
use App\Models\System;


use DB;

class EditController extends Controller
{
    // オリジナル編集区分の作成

    public function edit_create()
    {
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        
        $s_numbers = M_Division::where('DivCode','NumberDiv')->get();
        $s_edits = M_Division::where('DivCode','EditDiv')->get();
        $s_dates = M_Division::where('DivCode','DateDiv')->get();
        $s_numberClears = M_Division::where('DivCode','NumberClearDiv')->get();

        return view(
            'UnNumber.edit_create', compact('s_edits','s_dates','s_numbers', 's_numberClears', 'tenantCode','tenantBranch')
        );
    }

    public function edit_confirm(EditRequest $request)
    {
        $inputs = $request->all();
   
        $lengs = intval($inputs['lengs']);// 数値変換
        $initNumber = strlen($inputs['initNumber']);// 文字数変換
        if(isset($inputs['symbol'])){
            $symbol = strlen($inputs['symbol']);// 文字数変換
        }else{
            $symbol = 0;
        }

        $symbolNo = $lengs - $symbol;// 有効桁数から記号を引いた値（記号はマストで保持するので）

        // 桁数オーバーチェック
        $System = new System;
        $errLength = $System->lengthCheck($inputs,$lengs,$initNumber,$symbol,$symbolNo);
        if($errLength == 1){
            \Session::flash('err_msg' , '有効桁数を超えています');
                return back()->withInput(); 
        }

        // 記号忘れチェック
        if($inputs['editdiv'] == 4 || $inputs['editdiv'] == 5 ){
            if($inputs['symbol'] === null){
                \Session::flash('err_msg' , '記号を入力してください。');
                return back()->withInput(); 
            }

        }


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
        $t_numberclear = M_Division::where('DivCode','NumberClearDiv')->where('DivNo', $inputs['numbercleardiv'])->first();
        $t_tenant = DB::table('m_tenant')->where('TenantCode', $inputs['TenantCode'])->first();
        $t_tenantBranch = DB::table('m_tenantbranch')->where('TenantBranch', $inputs['TenantBranch'])->first();

        // dd($lengs);
        return view(
            'UnNumber.edit_confirm',compact('inputs','t_edit', 't_date','t_number', 't_numberclear', 't_tenant','t_tenantBranch','lengs')
        ); 
    }

    public function edit_store(EditRequest $request)
    {
        // セッションに保存したコピーしたデータを削除する
        \Session::forget(
            [
                'numberdiv','numberName',
                'initNumber',
                'symbol',
                'lengs',
                'editdiv','editName',
                'datediv','dateName',
                'numberCleardiv','numberClearName',
            ]
        );
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

    // 編集
    public function edit_edit($id)
    {
        $input = M_Numbering::find($id); 
        // dd($input);
        $get_numbers = M_Division::where('DivCode','NumberDiv')->where('DivNo',$input['numberdiv'])->first();
        $s_edits = M_Division::where('DivCode','EditDiv')->get();
        $get_edits = M_Division::where('DivCode','EditDiv')->where('DivNo',$input['editdiv'])->first();
        $s_dates = M_Division::where('DivCode','DateDiv')->get();
        $get_dates = M_Division::where('DivCode','DateDiv')->where('DivNo',$input['datediv'])->first();
        $s_numberClears = M_Division::where('DivCode','NumberClearDiv')->get();
        $get_numberClears = M_Division::where('DivCode','NumberClearDiv')->where('DivNo',$input['numbercleardiv'])->first();
        // dd($get_numberClears,$s_numberClears);
       
        if(is_null($input)){
            \Session::flash('err_msg' , 'データがありません。');
            return redirect( route('home') );
        }
        return view('UnNumber.edit_edit', 
        compact(
            'input','get_numbers',
            's_edits','get_edits',
            's_dates','get_dates',
            's_numberClears','get_numberClears',
        ));
    }

    // 更新
    public function edit_update(EditEditRequest $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        $lengs = intval($inputs['lengs']);// 数値変換
        $initNumber = strlen($inputs['initNumber']);// 文字数変換
        $symbol = strlen($inputs['symbol']);// 文字数変換
        // $maxleng = $lengs + $symbol;// 有効桁数と記号を足した値（合計値がMAX値を超えるとエラー）
        $symbolNo = $lengs - $symbol;// 有効桁数から記号を引いた値（記号はマストで保持するので）
        
        $System = new System;
        $errLength = $System->lengthCheck($inputs,$lengs,$initNumber,$symbol,$symbolNo);
        if($errLength == 1){
            \Session::flash('err_msg' , '有効桁数を超えています');
                return back()->withInput(); 
        }


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
                'numbercleardiv' => $inputs['numbercleardiv'],
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


    // 削除
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

    // コピー
    public function edit_copy($id)
    {
        // セッションに保存したコピーしたデータを削除する
        \Session::forget(
            [
                'numberdiv','numberName',
                'initNumber',
                'symbol',
                'lengs',
                'editdiv','editName',
                'datediv','dateName',
                'numberCleardiv','numberClearName',
            ]
        );
         
        // $inputs = M_Numbering::select('numberdiv','initNumber','symbol','lengs','editdiv','datediv')->find($id);
        $inputs = M_Numbering::
            with(['division_numbers' => function($query)
            {
                $query->where('DivCode','NumberDiv');
            }])
            ->with(['division_edits' => function($query)
            {
                $query->where('DivCode','EditDiv');
            }])
            ->with(['division_dates' => function($query)
            {
                $query->where('DivCode','DateDiv');
            }])
            ->with(['division_numberclears' => function($query)
            {
                $query->where('DivCode','NumberClearDiv');
            }])
            ->select('numberdiv','initNumber','symbol','lengs','editdiv','datediv','numbercleardiv')->find($id);
            // dd($inputs->division_numbers[0]->DivName);
        \Session::put(
            [
                'numberdiv' => $inputs->numberdiv,
                'numberName' => $inputs->division_numbers[0]->DivName,
                'initNumber' => $inputs->initNumber,
                'symbol' => $inputs->symbol,
                'lengs' => $inputs->lengs,
                'editdiv' => $inputs->editdiv,
                'editName' => $inputs->division_edits[0]->DivName,
                'datediv' => $inputs->datediv,
                'dateName' => $inputs->division_dates[0]->DivName,
                'numbercleardiv' => $inputs->numbercleardiv,
                'numberclearName' => $inputs->division_numberclears[0]->DivName,
            ]
        );
      
        \Session::flash('err_msg' , 'コピーしました。');
        return redirect( route('home'));
    }

    // 貼付け
    public function edit_paste()
    {
        $user = \Auth::user();
        $tenantCode = $user->tenantCode;
        $tenantBranch = $user->tenantBranch;
        // dd( $tenantBranch);
        
        $s_numbers = M_Division::where('DivCode','NumberDiv')->get();
        $s_edits = M_Division::where('DivCode','EditDiv')->get();
        $s_dates = M_Division::where('DivCode','DateDiv')->get();
        $s_numberClears = M_Division::where('DivCode','NumberClearDiv')->get();
       
        return view (
            'UnNumber.edit_paste', compact('s_edits','s_dates','s_numbers','s_numberClears', 'tenantCode','tenantBranch')
        );
    }

}
