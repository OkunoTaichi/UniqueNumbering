<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class M_NumberingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('M_Numbering')->insert([
            'id' => 1,

            'tenant_id' => '11111111',
            'tenant_name' => 'JTB',
            'tenantBranch_name' => '東京本社',

            'numberdiv' => '1',
            'editdiv' => '1',
            'datediv' => '1',

            'countNumber' => '123456789',
   
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 2,

            'tenant_id' => '11111111',
            'tenant_name' => 'JTB',
            'tenantBranch_name' => '東京本社',

            'numberdiv' => '2',
            'editdiv' => '2',
            'datediv' => '2',

            'countNumber' => '123456789',

        ]);
        DB::table('M_Numbering')->insert([
            'id' => 3,

            'tenant_id' => '11111111',
            'tenant_name' => 'JTB',
            'tenantBranch_name' => '東京本社',

            'numberdiv' => '3',
            'editdiv' => '1',
            'datediv' => '1',

            'countNumber' => '123456789',
 
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 4,

            'tenant_id' => '11111111',
            'tenant_name' => 'JTB',
            'tenantBranch_name' => '東京本社',

            'numberdiv' => '4',
            'editdiv' => '4',
            'datediv' => '1',

            'symbol' => 'CCC',
            'countNumber' => '123456789',

        ]);
        DB::table('M_Numbering')->insert([
            'id' => 5,

            'tenant_id' => '11111111',
            'tenant_name' => 'JTB',
            'tenantBranch_name' => '東京本社',

            'numberdiv' => '5',
            'editdiv' => '5',
            'datediv' => '3',

            'symbol' => 'Y',
            'countNumber' => '123456789',

        ]);
        DB::table('M_Numbering')->insert([
            'id' => 6,

            'tenant_id' => '11111111',
            'tenant_name' => 'JTB',
            'tenantBranch_name' => '東京本社',

            'numberdiv' => '6', // テナントIDごとにユニークキー
            'editdiv' => '3',
            'datediv' => '2',
            
            'countNumber' => '123456789',

        ]);
    }
}
