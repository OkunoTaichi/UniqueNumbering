<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class M_TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('M_Tenant')->insert([
            'id' => 1,
            'TenantCode' => 'JTB',
            'CompanyName' => 'JTB',
        ]);
        DB::table('M_Tenant')->insert([
            'id' => 2,
            'TenantCode' => 'Ra',
            'CompanyName' => '楽天',
        ]);
        DB::table('M_Tenant')->insert([
            'id' => 3,
            'TenantCode' => 'JP',
            'CompanyName' => '日本旅行',
        ]);
        DB::table('M_Tenant')->insert([
            'id' => 4,
            'TenantCode' => 'HAN9',
            'CompanyName' => '阪急交通社',
        ]);
        DB::table('M_Tenant')->insert([
            'id' => 5,
            'TenantCode' => 'ナバック',
            'CompanyName' => 'ナバック',
        ]);
    }
}
