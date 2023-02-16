<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class M_DivisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 採番区分
        DB::table('m_division')->insert([
            'DivCode' => 'NumberDiv',
            'DivNo' => '1',
            'DivName'=>'予約No',
        ]);
        DB::table('m_division')->insert([
            'DivCode' => 'NumberDiv',
            'DivNo' => '2',
            'DivName'=>'利用No',
        ]);
        DB::table('m_division')->insert([
            'DivCode' => 'NumberDiv',
            'DivNo' => '3',
            'DivName'=>'利用個別No',
        ]);
        DB::table('m_division')->insert([
            'DivCode' => 'NumberDiv',
            'DivNo' => '4',
            'DivName'=>'利用部屋No',
        ]);
        DB::table('m_division')->insert([
            'DivCode' => 'NumberDiv',
            'DivNo' => '5',
            'DivName'=>'伝票No',
        ]);
        DB::table('m_division')->insert([     
            'DivCode' => 'NumberDiv',
            'DivNo' => '6',
            'DivName'=>'予約金No',
        ]);
        DB::table('m_division')->insert([
            'DivCode' => 'NumberDiv',
            'DivNo' => '7',
            'DivName'=>'団体No',
        ]);
        DB::table('m_division')->insert([
            'DivCode' => 'NumberDiv',
            'DivNo' => '8',
            'DivName'=>'顧客No',
        ]);
        DB::table('m_division')->insert([
            'DivCode' => 'NumberDiv',
            'DivNo' => '9',
            'DivName'=>'会員No',
        ]);
        DB::table('m_division')->insert([ 
            'DivCode' => 'NumberDiv',
            'DivNo' => '10',
            'DivName'=>'領収書No',
        ]);
        DB::table('m_division')->insert([       
            'DivCode' => 'NumberDiv',
            'DivNo' => '11',
            'DivName'=>'領収書仮No',
        ]);
        DB::table('m_division')->insert([         
            'DivCode' => 'NumberDiv',
            'DivNo' => '12',
            'DivName'=>'請求書No',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'NumberDiv',
            'DivNo' => '13',
            'DivName'=>'請求書仮No',
        ]);
        DB::table('m_division')->insert([
            'DivCode' => 'NumberDiv',
            'DivNo' => '14',
            'DivName'=>'売掛No',
        ]);
        DB::table('m_division')->insert([ 
            'DivCode' => 'NumberDiv',
            'DivNo' => '15',
            'DivName'=>'回収No',
        ]);
        DB::table('m_division')->insert([    
            'DivCode' => 'NumberDiv',
            'DivNo' => '16',
            'DivName'=>'回収明細No',
        ]);
        DB::table('m_division')->insert([       
            'DivCode' => 'NumberDiv',
            'DivNo' => '17',
            'DivName'=>'見積No',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'NumberDiv',
            'DivNo' => '18',
            'DivName'=>'引継No',
        ]);
        DB::table('m_division')->insert([   
            'DivCode' => 'NumberDiv',
            'DivNo' => '19',
            'DivName'=>'ログID',
        ]);
        DB::table('m_division')->insert([  
            'DivCode' => 'NumberDiv',
            'DivNo' => '20',
            'DivName'=>'PDA呼出番号',
        ]);
        DB::table('m_division')->insert([    
            'DivCode' => 'NumberDiv',
            'DivNo' => '21',
            'DivName'=>'領収書用請求書No',
        ]);


        // 日付区分
        DB::table('m_division')->insert([   
            'DivCode' => 'DateDiv',
            'DivNo' => '1',
            'DivName'=>'サーバー日付',
            'Value1'=> 1 ,
        ]);
        DB::table('m_division')->insert([   
            'DivCode' => 'DateDiv',
            'DivNo' => '2',
            'DivName'=>'ホテルデイト',
            'Value2'=> 1 ,
        ]);
        DB::table('m_division')->insert([     
            'DivCode' => 'DateDiv',
            'DivNo' => '3',
            'DivName'=>'チェックイン日',
            'Value3'=> 1 ,
        ]);
        

        // 編集区分
        DB::table('m_division')->insert([        
            'DivCode' => 'EditDiv',
            'DivNo' => '1',
            'DivName'=>'連番',
            'Value4'=> 1 ,
        ]);
        DB::table('m_division')->insert([   
            'DivCode' => 'EditDiv',
            'DivNo' => '2',
            'DivName'=>'日付+連番',
            'Value2'=> 1 ,
            'Value4'=> 1 ,
        ]);
        DB::table('m_division')->insert([
            'DivCode' => 'EditDiv',
            'DivNo' => '3',
            'DivName'=>'日付＋"-"＋連番',
            'Value2'=> 1 ,
            'Value3'=> 1 ,
            'Value4'=> 1 ,
        ]);
        DB::table('m_division')->insert([    
            'DivCode' => 'EditDiv',
            'DivNo' => '4',
            'DivName'=>'記号+連番',
            'Value1'=> 1 ,
            'Value4'=> 1 ,
        ]);
        DB::table('m_division')->insert([      
            'DivCode' => 'EditDiv',
            'DivNo' => '5',
            'DivName'=>'記号+日付+連番',
            'Value1'=> 1 ,
            'Value2'=> 1 ,
            'Value4'=> 1 ,
        ]);

        // 採番クリア区分
        DB::table('m_division')->insert([        
            'DivCode' => 'NumberClearDiv',
            'DivNo' => '1',
            'DivName'=>'無し',
            'Value1'=> 1 ,
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'NumberClearDiv',
            'DivNo' => '2',
            'DivName'=>'日時',
            'Value2'=> 1 ,
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'NumberClearDiv',
            'DivNo' => '3',
            'DivName'=>'月次',
            'Value3'=> 1 ,
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'NumberClearDiv',
            'DivNo' => '4',
            'DivName'=>'年次',
            'Value4'=> 1 ,
        ]);

        // 権限区分
        DB::table('m_division')->insert([        
            'DivCode' => 'AuthorityDiv',
            'DivNo' => '1',
            'DivName'=>'更新',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'AuthorityDiv',
            'DivNo' => '2',
            'DivName'=>'参照',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'AuthorityDiv',
            'DivNo' => '3',
            'DivName'=>'不可',
        ]);
        
        // 権限区分
        DB::table('m_division')->insert([        
            'DivCode' => 'ProgramDiv',
            'DivNo' => '01',
            'DivName'=>'システムマスタ',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'ProgramDiv',
            'DivNo' => '02',
            'DivName'=>'予約管理',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'ProgramDiv',
            'DivNo' => '03',
            'DivName'=>'客室管理',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'ProgramDiv',
            'DivNo' => '04',
            'DivName'=>'会計管理',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'ProgramDiv',
            'DivNo' => '05',
            'DivName'=>'集計',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'ProgramDiv',
            'DivNo' => '06',
            'DivName'=>'分析',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'ProgramDiv',
            'DivNo' => '07',
            'DivName'=>'顧客管理',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'ProgramDiv',
            'DivNo' => '08',
            'DivName'=>'テナント管理',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'ProgramDiv',
            'DivNo' => '09',
            'DivName'=>'お知らせ管理',
        ]);
        DB::table('m_division')->insert([        
            'DivCode' => 'ProgramDiv',
            'DivNo' => '10',
            'DivName'=>'サイトコントローラー',
        ]);
      
        


    }
}
