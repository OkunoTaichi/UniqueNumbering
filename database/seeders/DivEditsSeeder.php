<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DivEditsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('EditDiv')->insert([
            'id' => 1,
            'edit_id' => '1',
            'edit_name' => '予約番号のみ',
            'edit_length' => '15',
            'memo' => '000000123456789',
            'created_at'=>'2033-01-16 14:26:37',
            'updated_at'=>'2033-01-16 14:26:37',
        ]);
        DB::table('EditDiv')->insert([
            'id' => 2,
            'edit_id' => '2',
            'edit_name' => '日付＋予約番号',
            'edit_length' => '7',
            'memo' => '202304070123456',
            'created_at'=>'2033-01-16 14:26:37',
            'updated_at'=>'2033-01-16 14:26:37',
        ]);
        DB::table('EditDiv')->insert([
            'id' => 3,
            'edit_id' => '3',
            'edit_name' => '日付＋"-"＋予約番号',
            'edit_length' => '6',
            'memo' => '20230407-012345',
            'created_at'=>'2033-01-16 14:26:37',
            'updated_at'=>'2033-01-16 14:26:37',
        ]);
        DB::table('EditDiv')->insert([
            'id' => 4,
            'edit_id' => '4',
            'edit_name' => '記号＋予約番号',
            'edit_length' => '15',
            'memo' => 'AB0000123456789',
            'created_at'=>'2033-01-16 14:26:37',
            'updated_at'=>'2033-01-16 14:26:37',
        ]);
        DB::table('EditDiv')->insert([
            'id' => 5,
            'edit_id' => '5',
            'edit_name' => '記号＋日付＋予約番号',
            'edit_length' => '7',
            'memo' => 'AB2023040701234',
            'created_at'=>'2033-01-16 14:26:37',
            'updated_at'=>'2033-01-16 14:26:37',
        ]);
        
    }
}
