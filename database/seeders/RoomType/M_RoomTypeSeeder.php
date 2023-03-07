<?php

namespace Database\Seeders\RoomType;

use Illuminate\Database\Seeder;
use DB;

class M_RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_room_type')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',
            'RoomTypeCode'=>'0001',
            'RoomTypeName'=>'ツイン',
            'RoomTypeAbName'=>'T',

            'RoomTypeDiv'=>'1',
            'OperationDiv'=>'1',
            'RemainingRoomDiv'=>'1',

            'Hidden'=>'1',
            'DisplayOrder'=>'0001',
        ]);
        DB::table('m_room_type')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',
            'RoomTypeCode'=>'0002',
            'RoomTypeName'=>'和室',
            'RoomTypeAbName'=>'W',

            'RoomTypeDiv'=>'1',
            'OperationDiv'=>'1',
            'RemainingRoomDiv'=>'1',

            // 'Hidden'=>'1',
            'DisplayOrder'=>'0002',
        ]);
        DB::table('m_room_type')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',
            'RoomTypeCode'=>'0003',
            'RoomTypeName'=>'おまかせ',
            'RoomTypeAbName'=>'おまかせ',

            'RoomTypeDiv'=>'2',
            'OperationDiv'=>'0',
            'RemainingRoomDiv'=>'0',

            'RealTypeCode'=>'0001',
            // 'Hidden'=>'1',
            'DisplayOrder'=>'0003',
        ]);

        DB::table('m_room_type')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',
            'RoomTypeCode'=>'0004',
            'RoomTypeName'=>'架空部屋',
            'RoomTypeAbName'=>'架空',

            'RoomTypeDiv'=>'2',
            'OperationDiv'=>'0',
            'RemainingRoomDiv'=>'0',

            // 'Hidden'=>'1',
            'DisplayOrder'=>'0004',
        ]);

        DB::table('m_room_type')->insert([
            'TenantCode' => 'ナバック',
            'TenantBranch' => '1111',
            'RoomTypeCode'=>'0005',
            'RoomTypeName'=>'卓球台',
            'RoomTypeAbName'=>'卓球',

            'RoomTypeDiv'=>'3',
            'OperationDiv'=>'0',
            'RemainingRoomDiv'=>'1',

            'DisplayOrder'=>'0004',
        ]);

        DB::table('m_room_type')->insert([
            'TenantCode' => 'テスト',
            'TenantBranch' => '1111',
            'RoomTypeCode'=>'0001',
            'RoomTypeName'=>'ツイン',
            'RoomTypeAbName'=>'T',

            'RoomTypeDiv'=>'1',
            'OperationDiv'=>'1',
            'RemainingRoomDiv'=>'1',

            'Hidden'=>'1',
            'DisplayOrder'=>'0001',
        ]);
        DB::table('m_room_type')->insert([
            'TenantCode' => 'テスト',
            'TenantBranch' => '2222',
            'RoomTypeCode'=>'0001',
            'RoomTypeName'=>'ツイン',
            'RoomTypeAbName'=>'T',

            'RoomTypeDiv'=>'1',
            'OperationDiv'=>'1',
            'RemainingRoomDiv'=>'1',

            'Hidden'=>'1',
            'DisplayOrder'=>'0001',
        ]);
    }
}
