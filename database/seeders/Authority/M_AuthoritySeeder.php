<?php

namespace Database\Seeders\Authority;// フォルダ入れたら忘れずに

use Illuminate\Database\Seeder;
use DB;

class M_AuthoritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_authority')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',
            'AuthorityCode'=>'0001',
            'AuthorityName'=>'システム管理',
            'AdminFlg'=>'1',
            'UpdatePerson'=>'1111',
        ]);
    }
}
