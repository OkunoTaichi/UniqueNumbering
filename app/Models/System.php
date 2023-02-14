<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reserve;
use App\Models\M_Numbering;
use App\Models\T_NumberInfo;
use App\Models\M_Division;

use DB;

class System extends Model
{
    use HasFactory;

    // 予約番号を発行するまでの処理 --------------------

    //  ➀ セレクトボックスで選択されたテナントコードとテナントブランチを元にm_numberingテーブルから該当のデータを絞込み
    public function editSearch($searchId,$searchId_2,$searchId_3){
        $query = M_Numbering::query();
        $edits = $query->with(['Tenants','TenantBranchs'])
        ->where('TenantCode',$searchId)
        ->where('TenantBranch',$searchId_2)->get();
        $edit = $edits->where('numberdiv',$searchId_3)->first();

        return $edit;
    }

    //  ➁ 採番するIDの処理 * $change_number 最後DBに更新
    public function numberSearch($countNumbers,$countNumber,$initNumber)
    {
        if($countNumbers != null){ // T_NumberInfoにデータがある場合
            // dd($countNumber,$initNumber);
            $change_number = $countNumber + $initNumber;

        }else{ // T_NumberInfoにデータがななくM_Numberingで初期値もない場合
            $change_number = $initNumber + 1;
        }
        return $change_number;
    }


    // ➃ 編集区分によって採番するパターンを変更する処理
    public function divisions($edit, $change_number, $dateTime)
    {
        $editNo = $edit['editdiv'];// 行特定後に編集区分Noを確認
    
        $EditDiv = M_Division::where('DivCode','EditDiv')// M_DivisionテーブルからDivCodeが'EditDiv'のみを抽出
        ->where('DivNo',$editNo)// 'DivNo'が上記で取得し番号とおなじものを抽出する。（ここでM_Divisionテーブルから行が特定される）
        ->first();
 
        $edit_length = $edit->lengs;// 有効桁数
        $length = intval($edit_length);//文字列を数値に変換
        $number_count = mb_strlen($change_number);//初期値を桁数に変換
        $symbol = $edit->symbol;// 記号

        if($symbol != null){
            $symbol_count = mb_strlen($symbol);//記号を文字数に変換
        }else{
            $symbol_count = 0;
        }

        if($edit['editdiv'] == 2 || $edit['editdiv'] == 5){
            $dateCount = 8;
        }elseif($edit['editdiv'] == 3){
            $dateCount = 9;
        }else{
            $dateCount = 0;
        }

        
        $total_count = $symbol_count + $number_count + $dateCount;//記号と初期値と日付の合計桁数


        // 表示する連番を初期値と有効桁数で編集する。
        if($length > $total_count)
        {
            $up_length = $length - ( $symbol_count + $dateCount );
            $reserve_id = str_pad($change_number,$up_length,'0', STR_PAD_LEFT);//有効桁数まで０で埋める

        }
        elseif($length = $total_count)
        {
            $reserve_id = $change_number;
        }

        // 上記で特定された行から各valueの値を関数化
        if($EditDiv['Value1'] !== null || $EditDiv['Value1'] === "0"){
            $val_1 = $symbol;// 記号
        }else{
            $val_1 = null;
        }
        if($EditDiv['Value2'] !== null || $EditDiv['Value2'] === "0"){
            $val_2 = $dateTime;// 日付
        }else{
            $val_2 = null;
        }
        if($EditDiv['Value3'] !== null || $EditDiv['Value3'] === "0"){
            $val_3 = '-';// ハイフン
        }else{
            $val_3 = null;
        }
        if($EditDiv['Value4'] !== null || $EditDiv['Value4'] === "0"){
            $val_4 = $reserve_id;// 連番
        }else{
            $val_4 = null;
        }
        
        $reserve_id = $val_1.$val_2.$val_3.$val_4;// 正式では名前変更し他方が良い（変更が縦続いているのでとりあえず元の関数名のまま進める）

        return $reserve_id;

    }
    


    // // ➃ 編集区分によって採番するパターンを変更する処理
    // public function division($edits, $change_number, $dateTime)
    // {
    //     $edit_id = $edits->editdiv;
    //     $edit_length = $edits->Divedits->edit_length;// 有効桁数
    //     $number_count = mb_strlen($change_number);//初期値を桁数に変換
    //     //ここから記号関連
    //     $symbol = $edits->symbol;// 記号
    //     if($symbol != null){
    //         $symbol_count = mb_strlen($symbol);//記号を文字数に変換
    //     }else{
    //         $symbol_count = 0;
    //     }
    //     $length = intval($edit_length);//文字列を数値に変換
    //     $total_count = $symbol_count + $number_count;//記号と初期値の合計値
    
    //     // 予約番号 のみ
    //     if($edit_id == 1)
    //     {
    //         if($number_count > $length)//初期値の合計が有効桁数より大きい場合
    //         {
    //             $d_length = $number_count - $length;//初期値と有効桁数の差分を代入する
    //             $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
    //             $reserve_id = $replace;
    //         }
    //         elseif($length > $number_count)
    //         {
    //             // $replace = str_pad($change_number,$length,'0', STR_PAD_LEFT);//有効桁数まで０で埋める
    //             // $reserve_id = $replace;  
    //             $reserve_id = $change_number;// 0埋めなし
    //         }
    //         elseif($length = $number_count)
    //         {
    //             $reserve_id = $change_number;
    //         }
    //     }

    //    // 日付＋予約番号
    //    if($edit_id == 2)
    //    {
    //        if($number_count > $length)//初期値の合計が有効桁数より大きい場合
    //        {
    //             $d_length = $number_count - $length;//初期値と有効桁数の差分を代入する
    //             //顧客のIDを各予約の連番にする場合
    //             $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
    //             $reserve_id = $dateTime. $replace;
    //        }
    //        elseif($length > $number_count)
    //        {
    //         //    $replace = str_pad($change_number,$length,'0', STR_PAD_LEFT);//有効桁数まで０で埋める
    //         //    $reserve_id = $dateTime. $replace;
    //             $reserve_id = $dateTime. $change_number;
    //        }
    //        elseif($length = $number_count)
    //        {
    //             $reserve_id = $dateTime. $change_number;
    //        }
    //    }

    //    //日付 + "-" + 予約番号
    //    if($edit_id == 3)
    //    {
    //        if($number_count > $length)//初期値の合計が有効桁数より大きい場合
    //        {
    //            $d_length = $number_count - $length;//初期値と有効桁数の差分を代入する
    //            $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
    //            $reserve_id = $dateTime. "-". $replace;
    //        }
    //        elseif($length > $number_count)
    //        {
    //         //    $replace = str_pad($change_number,$length,'0', STR_PAD_LEFT);//有効桁数まで０で埋める
    //         //    $reserve_id = $dateTime. "-". $replace;
    //             $reserve_id = $dateTime. "-". $change_number;
    //        }
    //        elseif($length = $number_count)
    //        {
    //            $reserve_id = $dateTime. "-". $change_number;
    //        }
    //    }

    //    //記号＋予約番号
    //    if($edit_id === 4)
    //    {
    //        if($total_count > $length)//初期値と記号の合計が有効桁数より大きい場合
    //        {
    //            $d_length = $total_count - $length;//記号と初期値の合計値 - 有効桁数 （初期値を減らす目的）
    //            $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
    //            $reserve_id = $symbol. $replace;
    //        }
    //        elseif($length > $total_count)
    //        {
    //         //    $c_length = $length - $symbol_count;//有効桁数 - 記号数 （初期値に対してのみ記号の数を引いた有効桁数分の０を追加する目的）
    //         //    $replace = str_pad($change_number,$c_length,'0', STR_PAD_LEFT);//指定の文字数まで０で埋める
    //         //    $reserve_id = $symbol. $replace;
    //             $reserve_id = $symbol. $change_number;
    //        }
    //        elseif($length = $total_count)
    //        {
    //             $reserve_id = $symbol. $change_number;
    //        }
      
    //    }

    //    //記号＋日付＋連番
    //    if($edit_id === 5){
           
    //        if($total_count > $length)//初期値と記号の合計が有効桁数より大きい場合
    //        {
    //            $d_length = $total_count - $length;//記号と初期値の合計値 - 有効桁数 （初期値を減らす目的）
    //            $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
    //            $reserve_id = $symbol. $dateTime. $replace;
    //        }
    //        elseif($length > $total_count)
    //        {
    //         //    $c_length = $length - $symbol_count;//有効桁数 - 記号数 （初期値に対してのみ記号の数を引いた有効桁数分の０を追加する目的）
    //         //    $replace = str_pad($change_number,$c_length,'0', STR_PAD_LEFT);//指定の文字数まで０で埋める
    //         //    $reserve_id = $symbol. $dateTime.  $replace; 
    //             $reserve_id = $symbol. $dateTime.  $change_number;
    //        }
    //        elseif($length = $total_count)
    //        {
    //            $reserve_id = $symbol. $dateTime.  $change_number;
    //        }
    //    }
    // //    dd($reserve_id);
    //     return $reserve_id;
    // }

    // ➄ 予約確定 バージョン
    public function update_create($edit, $reserve_id, $countNumber,$update_id,$dateTime)
    {
        // 予約確定する前にcount_idを更新するだけの処理
        DB::beginTransaction();
        try{
            
            T_NumberInfo::updateOrCreate(
                ['id'=> $update_id],
                [
                    "TenantCode" => $edit->TenantCode,
                    "TenantBranch" => $edit->TenantBranch,
                    "NumberDiv" => $edit->numberdiv,
                    "NumberDate" => $dateTime,
                    "No" => $reserve_id,
                    "CountNumber" => $countNumber,
                ]);
            
            DB::commit();

        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , '登録しました。');

       
    }

    // 送信時の桁数オーバーチェック
    public function lengthCheck($inputs,$lengs,$initNumber,$symbol,$symbolNo){
        $errLength = 0;
        if($inputs['editdiv'] == "1" || $inputs['editdiv'] == "4"){
            if(($initNumber + $symbol) > $lengs){
                $errLength = 1;
            }
 
        }elseif($inputs['editdiv'] == "2" || $inputs['editdiv'] == "5"){
            if(($initNumber + 8 + $symbol)> $lengs){
                $errLength = 1;
            }
  
        }elseif($inputs['editdiv'] == "3"){
            if(($initNumber + 9) > $lengs ){
                $errLength = 1;
            }
        };

        return $errLength;


    }

   
       
    

    



}
