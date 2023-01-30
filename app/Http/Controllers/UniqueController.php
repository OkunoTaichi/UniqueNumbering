<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\UnNumber;
use App\Models\TNumberInformation;
use DB;

class UniqueController extends Controller
{
    public function unique_index()
    {
        return view(
            'UnNumber.unique_index',
        );
    }

    public function unique_create(Request $request)
    {
        $inputs = $request->all();
        $client = DB::table('clients')->where('id', $inputs['SignIn'])->first();
        $edits = DB::table('M_Numbering')->where('tenant_id',[$client->tenant_id])->get();
        dd($inputs);
     

        return view(
            'UnNumber.unique_create', compact('client','edits')
        );
    }


    public function unique_confirm(Request $request)
    {
        $inputs = $request->all();// POSTされたデータを受け取る

        // 予約ナンバーを顧客のIDで採番する場合の処理（不要なら削除）
        // $change_number = $inputs['client_id'];

        // ➀ 各種予約項目ごとに最新の番号を取得する処理
        $numberSearch = new TNumberInformation;
        $change_number = $numberSearch->numberSearch($inputs);
        
        // ➁ un_numbersテーブルのテナントコードと予約名称で検索し区分特定する処理
        $divisionSearch = new TNumberInformation;
        $edit = $divisionSearch->divisionSearch($inputs);
        $edit_id = $edit->edit_id;//編集区分を特定
        $date_id = $edit->date_id;//日付区分を特定
        
        // ➂ 日付区分によって表示する日付を変更する処理
        $dateOrder = new TNumberInformation;
        $dateTime = $dateOrder->dateOrder($inputs, $date_id);

        // ➃ 編集区分によって採番するパターンを変更する処理
        $division = new TNumberInformation;
        $reserve_id = $division->division($edit_id, $change_number, $edit, $dateTime);
      
        return view(
            'UnNumber.unique_confirm',compact('inputs','edit','reserve_id','change_number')
        ); 
    }

    public function unique_store(Request $request)
    {
        $reserveInputs = $request->all();
        // dd($reserveInputs);
        
        DB::beginTransaction();
        try{
            // データを登録
            reserve::create($reserveInputs);
            DB::commit();
        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , '登録しました。');
        return view(
            'UnNumber.unique_index',
        );
    }


   
     


}
