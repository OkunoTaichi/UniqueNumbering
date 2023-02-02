<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class M_TenantBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('M_TenantBranch')->insert([
            'id' => 1,
            'TenantCode' => 'JTB',
            'TenantBranch' => '1111',
            'TenantBranchName' => '東京本社',
        ]);
        DB::table('M_TenantBranch')->insert([
            'id' => 2,
            'TenantCode' => 'Ra',
            'TenantBranch' => '2222',
            'TenantBranchName' => '関西支店',
        ]);
        DB::table('M_TenantBranch')->insert([
            'id' => 3,
            'TenantCode' => 'JP',
            'TenantBranch' => '3333',
            'TenantBranchName' => '九州支店',
        ]);
        DB::table('M_TenantBranch')->insert([
            'id' => 4,
            'TenantCode' => 'HAN9',
            'TenantBranch' => '4444',
            'TenantBranchName' => '東北支店',
        ]);
    }
}
