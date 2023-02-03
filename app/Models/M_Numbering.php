<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class M_Numbering extends Model    // 一覧検索のみ
{
    use HasFactory;

    //テーブル名
    protected $table = 'M_Numbering';

    //可変項目
    protected $fillable = 
    [
        'TenantCode',
        'TenantBranch',
        'numberdiv',
        'initNumber',
        'symbol',
        'editdiv',
        'datediv',
    ];

    // リレーション関係
    Public function DivEdits()
    {
        return $this->hasOne(DivEdit::class, 'edit_id','editdiv');
    }
    Public function DivDates()
    {
        // DivDateの'date_id'とこの't_number_information'の'datediv'を連結
        return $this->hasOne(DivDate::class, 'date_id','datediv');
    }
    Public function NumberDivs()
    {
        return $this->hasOne(NumberDiv::class, 'number_id','numberdiv');
    }
    



    // 全てが詰まったテーブル とりあえずゴールが数値なのでこの形
    Public function division_Numbers()
    {
        return $this->hasOne(M_Division::class, 'DivNo','numberdiv');
    }
    Public function division_edits()
    {
        return $this->hasOne(M_Division::class, 'DivNo','editdiv');
    }
    Public function division_dates()
    {
        return $this->hasOne(M_Division::class, 'DivNo','datediv');
    }


    

    Public function Tenants()
    {
        return $this->hasOne(Tenant::class, 'TenantCode','TenantCode');
    }
    Public function TenantBranchs()
    {
        return $this->hasOne(TenantBranch::class, 'TenantBranch','TenantBranch');
    }



// ***************** この下は別プログラム不要品*********************:


    // 予約番号を発行するまでの処理 --------------------

    // ➀ 各種予約項目ごとに最新の番号を取得する処理
    public function numberSearch($inputs)
    {
        $reserveNumbers = DB::table('reserves')// テナントコードと予約名称（ユニークキー）で編集区分を絞込み取得
            ->where('number_name', $inputs['number_name'])
            ->where('tenant_id', $inputs['tenant_id'])
            ->orderBy('created_at', 'DESC')
            ->first();
        
            
        // データベースにデータがあれば＋１、なければ１を代入する
        if($reserveNumbers != null){
            $reserveNumber = $reserveNumbers -> change_number;
            $change_number = $reserveNumber + 1;
        }else{
            $change_number = 1;
        }

        return $change_number;
    }

    // ➁ un_numbersテーブルのテナントコードと予約名称で検索し区分特定の処理
    public function divisionSearch($inputs)
    {
        // dd($inputs);
        $edit = DB::table('t_number_informations')
            ->where('tenant_id', $inputs['tenant_id'])
            ->where('number_name', $inputs['number_name'])
            ->first();
       
        return $edit;
    }

    // ➂ 日付区分によって表示する日付を変更する処理
    public function dateOrder($inputs, $date_id)
    {
        $client_id = intval($inputs['client_id']);// 数値変換

        //テスト用でclientsテーブルに日付区分関係を全て入れてます。
        $dateTimes =  DB::table('clients')// インプットされた会員番号から登録日などの各情報を取得
            ->where('client_id', $client_id)
            ->first();

        if($date_id == 1){
            //取得する時間のテーブルが別々なら$dateTimesからif文の中に入れる。
            $dateTime = $dateTimes -> registed_at;
            
        }elseif($date_id == 2){
            $dateTime = $dateTimes -> reserved_at;
            
        }elseif($date_id == 3){
            $dateTime = $dateTimes -> checked_at;

        }else{
            $dateTime = date('Ymd');//指定が無ければ現在時間を設定する（保険）
        }
        // DBテーブルから取得すると文字列かつ時間も取得するので、タイム型に変更しつつ年月日表示に変更
        $dateTime = date('Ymd', strtotime($dateTime));

        return $dateTime;
    }

    // ➃ 編集区分によって採番するパターンを変更する処理
    public function division($edit_id, $change_number, $edit, $dateTime)
    {
        // 予約番号 のみ
        if($edit_id == 1)
        {
            $number_count = mb_strlen($change_number);//初期値を文字数に変換
            $length = intval($edit->edit_length);//文字列を数値に変換
            
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
            $number_count = mb_strlen($change_number);//初期値を文字数に変換
            $length = intval($edit->edit_length);//文字列を数値に変換
       
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
            $number_count = mb_strlen($change_number);//初期値を文字数に変換
            $length = intval($edit->edit_length);//文字列を数値に変換
            
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
            $number_count = mb_strlen($change_number);//初期値を文字数に変換
            //ここから記号関連
            $symbol_count = mb_strlen($edit->Symbol);//記号を文字数に変換
            $length = intval($edit->edit_length);//文字列を数値に変換
            $total_count = $symbol_count + $number_count;//記号と初期値の合計値
            
            if($total_count > $length)//初期値と記号の合計が有効桁数より大きい場合
            {
                $d_length = $total_count - $length;//記号と初期値の合計値 - 有効桁数 （初期値を減らす目的）
                $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
                $reserve_id = $edit->Symbol. $replace;
            }
            elseif($length > $total_count)
            {
                $c_length = $length - $symbol_count;//有効桁数 - 記号数 （初期値に対してのみ記号の数を引いた有効桁数分の０を追加する目的）
                $replace = str_pad($change_number,$c_length,'0', STR_PAD_LEFT);//指定の文字数まで０で埋める
                $reserve_id = $edit->Symbol. $replace;
            }
            elseif($length = $total_count)
            {
                $reserve_id = $edit->Symbol. $change_number;
            }
        }

        //記号＋日付＋連番
        if($edit_id === 5){
            $number_count = mb_strlen($change_number);//初期値を文字数に変換
            //ここから記号関連
            $symbol_count = mb_strlen($edit->Symbol);//記号を文字数に変換
            $length = intval($edit->edit_length);//文字列を数値に変換
            $total_count = $symbol_count + $number_count;//記号と初期値の合計値
            
            if($total_count > $length)//初期値と記号の合計が有効桁数より大きい場合
            {
                $d_length = $total_count - $length;//記号と初期値の合計値 - 有効桁数 （初期値を減らす目的）
                $replace = substr( $change_number , $d_length, strlen($change_number) - $d_length );//指定の文字数まで先頭を除外する
                $reserve_id = $edit->Symbol. $dateTime. $replace;
            }
            elseif($length > $total_count)
            {
                $c_length = $length - $symbol_count;//有効桁数 - 記号数 （初期値に対してのみ記号の数を引いた有効桁数分の０を追加する目的）
                $replace = str_pad($change_number,$c_length,'0', STR_PAD_LEFT);//指定の文字数まで０で埋める
                $reserve_id = $edit->Symbol. $dateTime.  $replace; 
            }
            elseif($length = $total_count)
            {
                $reserve_id = $edit->Symbol. $dateTime.  $change_number;
            }
        }

       
        return $reserve_id;

    }


}


