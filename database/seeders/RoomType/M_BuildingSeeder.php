<?php

namespace Database\Seeders\RoomType;

use Illuminate\Database\Seeder;
use DB;

class M_BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_building')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',
            'BuildingCode'=>'H',
            'BuildingName'=>'本館',
            'BuildingAbName'=>'本',
            'Hidden'=>'1',
            'DisplayOrder'=>'0001',
        ]);

        DB::table('m_building')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',
            'BuildingCode'=>'N',
            'BuildingName'=>'新館',
            'BuildingAbName'=>'新',
            'Hidden'=>'1',
            'DisplayOrder'=>'0002',
        ]);

        DB::table('m_building')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',
            'BuildingCode'=>'G',
            'BuildingName'=>'グランピング',
            'BuildingAbName'=>'G',
            // 'Hidden'=>'1',
            'DisplayOrder'=>'0003',
        ]);


        DB::table('m_building')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '3333',
            'BuildingCode'=>'H',
            'BuildingName'=>'本館',
            'BuildingAbName'=>'本',
            'Hidden'=>'1',
            'DisplayOrder'=>'0001',
        ]);
        DB::table('m_building')->insert([
            'TenantCode' => 'テスト',
            'TenantBranch' => '1111',
            'BuildingCode'=>'H',
            'BuildingName'=>'本館',
            'BuildingAbName'=>'本',
            'Hidden'=>'1',
            'DisplayOrder'=>'0001',
        ]);
    }
}
