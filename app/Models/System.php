<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reserve;
use DB;

class System extends Model
{
    use HasFactory;

    // 予約番号を発行するまでの処理 --------------------

    
    //  ➁ 採番するIDの処理 * $change_number 最後DBに更新
    public function numberSearch($edits)
    {
        $count_id = $edits->countNumber;// 採番基準となる連番を代入

        
        if($count_id != null){
            $change_number = $count_id + 1;
        }else{
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
        $symbol_count = mb_strlen($symbol);//記号を文字数に変換
        $length = intval($edit_length);//文字列を数値に変換
        $total_count = $symbol_count + $number_count;//記号と初期値の合計値
     

        // dd($symbol);
   
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
                $replace = str_pad($change_number,$length,'0', STR_PAD_LEFT);//有効桁数まで０で埋める
                $reserve_id = $replace;  
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
               $replace = str_pad($change_number,$length,'0', STR_PAD_LEFT);//有効桁数まで０で埋める
               $reserve_id = $dateTime. $replace;
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
               $replace = str_pad($change_number,$length,'0', STR_PAD_LEFT);//有効桁数まで０で埋める
               $reserve_id = $dateTime. "-". $replace;
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
               $c_length = $length - $symbol_count;//有効桁数 - 記号数 （初期値に対してのみ記号の数を引いた有効桁数分の０を追加する目的）
               $replace = str_pad($change_number,$c_length,'0', STR_PAD_LEFT);//指定の文字数まで０で埋める
               $reserve_id = $symbol. $replace;
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
               $c_length = $length - $symbol_count;//有効桁数 - 記号数 （初期値に対してのみ記号の数を引いた有効桁数分の０を追加する目的）
               $replace = str_pad($change_number,$c_length,'0', STR_PAD_LEFT);//指定の文字数まで０で埋める
               $reserve_id = $symbol. $dateTime.  $replace; 
           }
           elseif($length = $total_count)
           {
               $reserve_id = $symbol. $dateTime.  $change_number;
           }
       }
        return $reserve_id;
    }

    // ➄ 予約確定する前にcount_idを更新するだけの処理。（今回はただの採番の為ユニークキーになるのであればOK）
    public function update_id($edits, $change_number)
    {
        DB::beginTransaction();
        try{
            // 予約確定する前にcount_idを更新するだけの処理
            $update = M_Numbering::find($edits->id);
            $update->update([
                "countNumber" => $change_number,
            ]);
            DB::commit();

        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , 'まだ予約は完了しておりません。');
        

    }

    // ➄ 予約確定 バージョン
    public function update_create($edits, $reserve_id, $change_number, $client)
    {
        // dd($reserve_id);
        // 予約確定する前にcount_idを更新するだけの処理
        $update = M_Numbering::find($edits->id);
        $update->update([
            "countNumber" => $change_number,
            "initNumber" => $reserve_id,
        ]);

        DB::beginTransaction();
        try{
        // 予約確定でreserves予約テーブルに登録する処理
        Reserve::create([
            "number_name" => $edits->NumberDivs->number_name,
            "reserve_id" => $reserve_id,
            "client_id" => $client->client_id,
            "client_name" => $client->client_name,
            "tenant_id" => $edits->tenant_id,
        ]);

        DB::commit();

        }catch(\Throwable $e){
            DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg' , '登録しました。');

       
    }

    



}
