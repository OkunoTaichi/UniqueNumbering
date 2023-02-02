<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DivNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('numberdiv')->insert([
            'id' => 1,
            'number_id' => '1',
            'number_name' => '予約No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 2,
            'number_id' => '2',
            'number_name' => '利用No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 3,
            'number_id' => '3',
            'number_name' => '利用個別No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 4,
            'number_id' => '4',
            'number_name' => '利用部屋No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 5,
            'number_id' => '5',
            'number_name' => '伝票No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 6,
            'number_id' => '6',
            'number_name' => '予約金No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 7,
            'number_id' => '7',
            'number_name' => '団体No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 8,
            'number_id' => '8',
            'number_name' => '顧客No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 9,
            'number_id' => '9',
            'number_name' => '会員No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 10,
            'number_id' => '10',
            'number_name' => '領収書No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 11,
            'number_id' => '11',
            'number_name' => '領収書仮No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 12,
            'number_id' => '12',
            'number_name' => '請求書No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 13,
            'number_id' => '13',
            'number_name' => '請求書仮No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 14,
            'number_id' => '14',
            'number_name' => '売掛No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 15,
            'number_id' => '15',
            'number_name' => '回収No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 16,
            'number_id' => '16',
            'number_name' => '回収明細No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 17,
            'number_id' => '17',
            'number_name' => '見積No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 18,
            'number_id' => '18',
            'number_name' => '引継No',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 19,
            'number_id' => '19',
            'number_name' => 'ログID',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 20,
            'number_id' => '20',
            'number_name' => 'PDA呼出番号',
        ]);
        DB::table('numberdiv')->insert([
            'id' => 21,
            'number_id' => '21',
            'number_name' => '領収書用請求書No',
        ]);
    }
}
