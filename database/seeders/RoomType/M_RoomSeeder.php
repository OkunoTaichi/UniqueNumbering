<?php

namespace Database\Seeders\RoomType;

use Illuminate\Database\Seeder;
use DB;

class M_RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_room')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',

            'RoomNo'=>'201',
            'BuildingCode'=>'本館',
            'RoomTypeCode'=>'ツイン',
            'RoomName'=>'201',
            'RoomAbName'=>'201',
            'CapacityMax'=>'2',
            'CapacityMin'=>'1',
            'Floor'=>'2',
            'Hidden'=>'1',
            'DisplayOrder'=>'0201',
        ]);

        DB::table('m_room')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',

            'RoomNo'=>'202',
            'BuildingCode'=>'本館',
            'RoomTypeCode'=>'和室',
            'RoomName'=>'金木犀',
            'RoomAbName'=>'金木犀',
            'CapacityMax'=>'4',
            'CapacityMin'=>'1',
            'Floor'=>'2',
            'Hidden'=>'1',
            'DisplayOrder'=>'0201',
        ]);

        DB::table('m_room')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',

            'RoomNo'=>'8001',
            'BuildingCode'=>'本館',
            'RoomTypeCode'=>'卓球',
            'RoomName'=>'卓球',
            'RoomAbName'=>'卓球',
            'CapacityMax'=>'8',
            'CapacityMin'=>'0',
            'Floor'=>'2',
            // 'Hidden'=>'1',
            'DisplayOrder'=>'8001',
        ]);

        DB::table('m_room')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '2222',

            'RoomNo'=>'201',
            'BuildingCode'=>'本館',
            'RoomTypeCode'=>'ツイン',
            'RoomName'=>'201',
            'RoomAbName'=>'201',
            'CapacityMax'=>'2',
            'CapacityMin'=>'1',
            'Floor'=>'2',
            'Hidden'=>'1',
            'DisplayOrder'=>'0201',
        ]);
        DB::table('m_room')->insert([
            'TenantCode' => 'テスト',
            'TenantBranch' => '1111',

            'RoomNo'=>'201',
            'BuildingCode'=>'本館',
            'RoomTypeCode'=>'ツイン',
            'RoomName'=>'201',
            'RoomAbName'=>'201',
            'CapacityMax'=>'2',
            'CapacityMin'=>'1',
            'Floor'=>'2',
            'Hidden'=>'1',
            'DisplayOrder'=>'0201',
        ]);
    }
}
