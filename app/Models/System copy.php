<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reserve;
use App\Models\M_Numbering;
use App\Models\T_NumberInfo;

use DB;

class System extends Model
{
    use HasFactory;

    // 予約番号を発行するまでの処理 --------------------

    //  ➀ セレクトボックスで選択されたテナントコードとテナントブランチを元にm_numberingテーブルから該当のデータを絞込み
    public function editSearch($searchId,$searchId_2,$searchId_3){
        $query = M_Numbering::query();
        $edits = $query->with(['Tenants','TenantBranchs'])->where('TenantCode',$searchId)->where('TenantBranch',$searchId_2)->get();
        $edit = $edits->where('numberdiv',$searchId_3)->first();
        return $edit;
    }

    //  ➁ 採番するIDの処理 * $change_number 最後DBに更新
    public function numberSearch($countNumbers,$edit)
    {
        if($countNumbers != null){ // T_NumberInfoにデータがある場合
            $countNumber = $countNumbers -> CountNumber;
            $change_number = $countNumber + 1;

        }elseif($edit->initNumber != null){ // T_NumberInfoにデータがないがM_Numberingで初期値がある場合
            $initNumber = $edit->initNumber;
            $change_number = $initNumber + 1;

        }else{ // T_NumberInfoにデータがななくM_Numberingで初期値もない場合
            $change_number = 1;
        }
        return $change_number;
    }

    // ➃ 編集区分によって採番するパターンを変更する処理
    public function division($edits, $change_number, $dateTime)
    {
        $edit_id = $edits->editdiv;
        $edit_length = $edits->Divedits->edit_length;// 有効桁数
        $number_count = mb_strlen($change_number);//初期値を桁数に変換
        //ここから記号関連
        $symbol = $edits->symbol;// 記号
        if($symbol != null){
            $symbol_count = mb_strlen($symbol);//記号を文字数に変換
        }else{
            $symbol_count = 0;
        }
        $length = intval($edit_length);//文字列を数値に変換
        $total_count = $symbol_count + $number_count;//記号と初期値の合計値
    
        // 予約番号 のみ
        if($edit_id == 1)
        {
            if($number_count > $length)//初期値の合計が有効桁数より大きい場合
            {
                $d_length = $number_count - $length;//初期値と有効桁数の差分を代入する
                $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
                $reserve_id = $replace;
            }
            elseif($length > $number_count)
            {
                // $replace = str_pad($change_number,$length,'0', STR_PAD_LEFT);//有効桁数まで０で埋める
                // $reserve_id = $replace;  
                $reserve_id = $change_number;// 0埋めなし
            }
            elseif($length = $number_count)
            {
                $reserve_id = $change_number;
            }
        }

       // 日付＋予約番号
       if($edit_id == 2)
       {
           if($number_count > $length)//初期値の合計が有効桁数より大きい場合
           {
                $d_length = $number_count - $length;//初期値と有効桁数の差分を代入する
                //顧客のIDを各予約の連番にする場合
                $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
                $reserve_id = $dateTime. $replace;
           }
           elseif($length > $number_count)
           {
            //    $replace = str_pad($change_number,$length,'0', STR_PAD_LEFT);//有効桁数まで０で埋める
            //    $reserve_id = $dateTime. $replace;
                $reserve_id = $dateTime. $change_number;
           }
           elseif($length = $number_count)
           {
                $reserve_id = $dateTime. $change_number;
           }
       }

       //日付 + "-" + 予約番号
       if($edit_id == 3)
       {
           if($number_count > $length)//初期値の合計が有効桁数より大きい場合
           {
               $d_length = $number_count - $length;//初期値と有効桁数の差分を代入する
               $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
               $reserve_id = $dateTime. "-". $replace;
           }
           elseif($length > $number_count)
           {
            //    $replace = str_pad($change_number,$length,'0', STR_PAD_LEFT);//有効桁数まで０で埋める
            //    $reserve_id = $dateTime. "-". $replace;
                $reserve_id = $dateTime. "-". $change_number;
           }
           elseif($length = $number_count)
           {
               $reserve_id = $dateTime. "-". $change_number;
           }
       }

       //記号＋予約番号
       if($edit_id === 4)
       {
           if($total_count > $length)//初期値と記号の合計が有効桁数より大きい場合
           {
               $d_length = $total_count - $length;//記号と初期値の合計値 - 有効桁数 （初期値を減らす目的）
               $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
               $reserve_id = $symbol. $replace;
           }
           elseif($length > $total_count)
           {
            //    $c_length = $length - $symbol_count;//有効桁数 - 記号数 （初期値に対してのみ記号の数を引いた有効桁数分の０を追加する目的）
            //    $replace = str_pad($change_number,$c_length,'0', STR_PAD_LEFT);//指定の文字数まで０で埋める
            //    $reserve_id = $symbol. $replace;
                $reserve_id = $symbol. $change_number;
           }
           elseif($length = $total_count)
           {
                $reserve_id = $symbol. $change_number;
           }
      
       }

       //記号＋日付＋連番
       if($edit_id === 5){
           
           if($total_count > $length)//初期値と記号の合計が有効桁数より大きい場合
           {
               $d_length = $total_count - $length;//記号と初期値の合計値 - 有効桁数 （初期値を減らす目的）
               $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
               $reserve_id = $symbol. $dateTime. $replace;
           }
           elseif($length > $total_count)
           {
            //    $c_length = $length - $symbol_count;//有効桁数 - 記号数 （初期値に対してのみ記号の数を引いた有効桁数分の０を追加する目的）
            //    $replace = str_pad($change_number,$c_length,'0', STR_PAD_LEFT);//指定の文字数まで０で埋める
            //    $reserve_id = $symbol. $dateTime.  $replace; 
                $reserve_id = $symbol. $dateTime.  $change_number;
           }
           elseif($length = $total_count)
           {
               $reserve_id = $symbol. $dateTime.  $change_number;
           }
       }
    //    dd($reserve_id);
        return $reserve_id;
    }

    // ➄ 予約確定 バージョン
    public function update_create($edits, $reserve_id, $change_number,$update_id)
    {
     
        // 予約確定する前にcount_idを更新するだけの処理
        DB::beginTransaction();
        try{

            T_NumberInfo::updateOrCreate(
                ['id'=> $update_id],
                [
                    "TenantCode" => $edits->TenantCode,
                    "TenantBranch" => $edits->TenantBranch,
                    "NumberDiv" => $edits->numberdiv,
                    "DateDiv" => $edits->datediv,
                    "No" => $reserve_id,
                    "CountNumber" => $change_number,
                ]);
            
            DB::commit();

        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , '登録しました。');

       
    }

    



}
