<?php

namespace Database\Seeders\Authority;

use Illuminate\Database\Seeder;
use DB;

class M_ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_program')->insert([
            'ProgramID' => 'RSV0010',
            'ProgramDiv' => '01',// システムマスタ
            'ProgramName'=>'システムマスタ',
            // 'UpdatePerson'=>'1111',
        ]);
        DB::table('m_program')->insert([
            'ProgramID' => 'RSV0011',
            'ProgramDiv' => '02',// システムマスタ
            'ProgramName'=>'予約管理',
            // 'UpdatePerson'=>'1111',
        ]);
        DB::table('m_program')->insert([
            'ProgramID' => 'RSV0012',
            'ProgramDiv' => '03',// システムマスタ
            'ProgramName'=>'客室管理',
            // 'UpdatePerson'=>'1111',
        ]);
        DB::table('m_program')->insert([
            'ProgramID' => 'RSV0020',
            'ProgramDiv' => '04',// システムマスタ
            'ProgramName'=>'会計管理',
            // 'UpdatePerson'=>'1111',
        ]);
        DB::table('m_program')->insert([
            'ProgramID' => 'RSV0021',
            'ProgramDiv' => '05',// システムマスタ
            'ProgramName'=>'集計',
            // 'UpdatePerson'=>'1111',
        ]);
        DB::table('m_program')->insert([
            'ProgramID' => 'RSV0022',
            'ProgramDiv' => '06',// システムマスタ
            'ProgramName'=>'分析',
            // 'UpdatePerson'=>'1111',
        ]);
        DB::table('m_program')->insert([
            'ProgramID' => 'RSV0030',
            'ProgramDiv' => '07',// システムマスタ
            'ProgramName'=>'顧客管理',
            // 'UpdatePerson'=>'1111',
        ]);
        DB::table('m_program')->insert([
            'ProgramID' => 'RSV0031',
            'ProgramDiv' => '08',// システムマスタ
            'ProgramName'=>'テナント管理',
            // 'UpdatePerson'=>'1111',
        ]);
        DB::table('m_program')->insert([
            'ProgramID' => 'RSV0032',
            'ProgramDiv' => '09',// システムマスタ
            'ProgramName'=>'お知らせ管理',
            // 'UpdatePerson'=>'1111',
        ]);
        DB::table('m_program')->insert([
            'ProgramID' => 'RSV0040',
            'ProgramDiv' => '10',// システムマスタ
            'ProgramName'=>'サイトコントローラー',
            // 'UpdatePerson'=>'1111',
        ]);
     
     
    }
}
