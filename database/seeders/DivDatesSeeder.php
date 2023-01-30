<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DivDatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('DateDiv')->insert([
            'id' => 1,
            'date_id' => '1',
            'date_name' => 'サーバー日付',

            'memo' => '登録された日',
            'created_at'=>'2033-11-16 14:26:37',
            'updated_at'=>'2033-11-16 14:26:37',
        ]);
        DB::table('DateDiv')->insert([
            'id' => 2,
            'date_id' => '2',
            'date_name' => 'ホテルデイト',

            'memo' => '予約日',
            'created_at'=>'2033-11-16 14:26:37',
            'updated_at'=>'2033-11-16 14:26:37',
        ]);
        DB::table('DateDiv')->insert([
            'id' => 3,
            'date_id' => '3',
            'date_name' => 'チェックイン日',

            'memo' => 'チェックインされた日',
            'created_at'=>'2033-11-16 14:26:37',
            'updated_at'=>'2033-11-16 14:26:37',
        ]);
       
        
    }
}
