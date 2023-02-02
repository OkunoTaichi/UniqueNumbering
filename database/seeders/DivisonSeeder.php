<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DivisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 採番区分
        DB::table('divisions')->insert([
            'id' => 1,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '1',
            'flagName'=>'予約No',
        ]);
        DB::table('divisions')->insert([
            'id' => 2,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '2',
            'flagName'=>'利用No',
        ]);
        DB::table('divisions')->insert([
            'id' => 3,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '3',
            'flagName'=>'利用個別No',
        ]);
        DB::table('divisions')->insert([
            'id' => 4,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '4',
            'flagName'=>'利用部屋No',
        ]);
        DB::table('divisions')->insert([
            'id' => 5,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '5',
            'flagName'=>'伝票No',
        ]);
        DB::table('divisions')->insert([
            'id' => 6,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '6',
            'flagName'=>'予約金No',
        ]);
        DB::table('divisions')->insert([
            'id' => 7,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '7',
            'flagName'=>'団体No',
        ]);
        DB::table('divisions')->insert([
            'id' => 8,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '8',
            'flagName'=>'顧客No',
        ]);
        DB::table('divisions')->insert([
            'id' => 9,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '9',
            'flagName'=>'会員No',
        ]);
        DB::table('divisions')->insert([
            'id' => 10,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '10',
            'flagName'=>'領収書No',
        ]);
        DB::table('divisions')->insert([
            'id' => 11,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '11',
            'flagName'=>'領収書仮No',
        ]);
        DB::table('divisions')->insert([
            'id' => 12,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '12',
            'flagName'=>'請求書No',
        ]);
        DB::table('divisions')->insert([
            'id' => 13,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '13',
            'flagName'=>'請求書仮No',
        ]);
        DB::table('divisions')->insert([
            'id' => 14,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '14',
            'flagName'=>'売掛No',
        ]);
        DB::table('divisions')->insert([
            'id' => 15,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '15',
            'flagName'=>'回収No',
        ]);
        DB::table('divisions')->insert([
            'id' => 16,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '16',
            'flagName'=>'回収明細No',
        ]);
        DB::table('divisions')->insert([
            'id' => 17,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '17',
            'flagName'=>'見積No',
        ]);
        DB::table('divisions')->insert([
            'id' => 18,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '18',
            'flagName'=>'引継No',
        ]);
        DB::table('divisions')->insert([
            'id' => 19,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '19',
            'flagName'=>'ログID',
        ]);
        DB::table('divisions')->insert([
            'id' => 20,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '20',
            'flagName'=>'PDA呼出番号',
        ]);
        DB::table('divisions')->insert([
            'id' => 21,
            'divisionName' => '採番区分',
            'divisionCode' => 'NumberDiv',
            'flagCode' => '21',
            'flagName'=>'領収書用請求書No',
        ]);


        // 日付区分
        DB::table('divisions')->insert([
            'id' => 22,
            'divisionName' => '日付区分',
            'divisionCode' => 'DateDiv',
            'flagCode' => '1',
            'flagName'=>'サーバー日付',
        ]);
        DB::table('divisions')->insert([
            'id' => 23,
            'divisionName' => '日付区分',
            'divisionCode' => 'DateDiv',
            'flagCode' => '2',
            'flagName'=>'ホテルデイト',
        ]);
        DB::table('divisions')->insert([
            'id' => 24,
            'divisionName' => '日付区分',
            'divisionCode' => 'DateDiv',
            'flagCode' => '3',
            'flagName'=>'チェックイン日',
        ]);
        

        // 編集区分
        DB::table('divisions')->insert([
            'id' => 25,
            'divisionName' => '編集区分',
            'divisionCode' => 'EditDiv',
            'flagCode' => '1',
            'flagName'=>'連番',
        ]);
        DB::table('divisions')->insert([
            'id' => 26,
            'divisionName' => '編集区分',
            'divisionCode' => 'EditDiv',
            'flagCode' => '2',
            'flagName'=>'日付+連番',
        ]);
        DB::table('divisions')->insert([
            'id' => 27,
            'divisionName' => '編集区分',
            'divisionCode' => 'EditDiv',
            'flagCode' => '3',
            'flagName'=>'日付＋"-"＋予約番号',
        ]);
        DB::table('divisions')->insert([
            'id' => 28,
            'divisionName' => '編集区分',
            'divisionCode' => 'EditDiv',
            'flagCode' => '4',
            'flagName'=>'記号+連番',
        ]);
        DB::table('divisions')->insert([
            'id' => 29,
            'divisionName' => '編集区分',
            'divisionCode' => 'EditDiv',
            'flagCode' => '5',
            'flagName'=>'記号+日付+連番',
        ]);

        
        


    }
}
