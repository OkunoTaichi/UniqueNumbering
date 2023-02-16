<?php

namespace Database\Seeders\Authority;

use Illuminate\Database\Seeder;
use DB;

class M_AuthorityDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_authoritydetail')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',
            'AuthorityCode'=>'0001',
            'ProgramID'=>'RSV0010',
            'AuthorityDiv'=>'1',// 更新
            'UpdatePerson'=>'1111',
        ]);
    }
}
