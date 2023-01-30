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
        DB::table('M_TenantBranchtable')->insert([
            'id' => 1,
            'TenantCode' => 'JTB',
            'TenantBranch' => '111',
            'TenantBranchName' => '東京本社',
        ]);
        DB::table('M_TenantBranchtable')->insert([
            'id' => 2,
            'TenantCode' => 'Ra',
            'TenantBranch' => '222',
            'TenantBranchName' => '関西支店',
        ]);
        DB::table('M_TenantBranchtable')->insert([
            'id' => 3,
            'TenantCode' => 'JP',
            'TenantBranch' => '333',
            'TenantBranchName' => '九州支店',
        ]);
        DB::table('M_TenantBranchtable')->insert([
            'id' => 4,
            'TenantCode' => 'HAN9',
            'TenantBranch' => '444',
            'TenantBranchName' => '東北支店',
        ]);
    }
}
