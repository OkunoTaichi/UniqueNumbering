<?php

namespace Database\Seeders\Person;

use Illuminate\Database\Seeder;
use DB;

class M_PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_person')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',// システムマスタ
            'PersonCode'=>'nvc789',
            'PersonName'=>'ナバック太郎',
            'AuthorityCode'=>'789',
            'Password'=>'パスワード',
            'DisplayOrder'=>'1',
        ]);

        DB::table('m_person')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',// システムマスタ
            'PersonCode'=>'nvcナバック',
            'PersonName'=>'ナバック太郎',
            'AuthorityCode'=>'123',
            'Hidden'=>'1',
            'Password'=>'パスワード',
            'DisplayOrder'=>'1',
        ]);

        DB::table('m_person')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',// システムマスタ
            'PersonCode'=>'789',
            'PersonName'=>'太郎',
            'AuthorityCode'=>'456',
            'Password'=>'パスワード',
            'DisplayOrder'=>'2',
        ]);
    }
}
