<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class M_NumberingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('M_Numbering')->insert([
            'id' => 1,
            'TenantCode' => 'JTB',
            'TenantBranch' => '1111',
            'numberdiv' => '1',
            'initNumber' => '100000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '1',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 2,
            'TenantCode' => 'JTB',
            'TenantBranch' => '1111',
            'numberdiv' => '2',
            'initNumber' => '200000',
            'editdiv' => '2',
            'lengs' => '7',
            'datediv' => '2',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 3,
            'TenantCode' => 'JTB',
            'TenantBranch' => '1111',
            'numberdiv' => '3',
            'initNumber' => '300000',
            'editdiv' => '3',
            'lengs' => '6',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 4,
            'TenantCode' => 'JTB',
            'TenantBranch' => '1111',
            'numberdiv' => '4',
            'initNumber' => '400000',
            'editdiv' => '4',
            'lengs' => '15',
            'datediv' => '1',
            'symbol' => 'JTB',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 5,
            'TenantCode' => 'JTB',
            'TenantBranch' => '1111',
            'numberdiv' => '5',
            'initNumber' => '500000',
            'editdiv' => '5',
            'lengs' => '7',
            'datediv' => '2',
            'symbol' => 'JTB',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 6,
            'TenantCode' => 'JTB',
            'TenantBranch' => '1111',
            'numberdiv' => '6',
            'initNumber' => '60000',
            'editdiv' => '5',
            'lengs' => '7',
            'datediv' => '2',
            'symbol' => 'JTB',
        ]);


        DB::table('M_Numbering')->insert([
            'id' => 7,
            'TenantCode' => 'JTB',
            'TenantBranch' => '2222',
            'numberdiv' => '1',
            'initNumber' => '10000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 8,
            'TenantCode' => 'JTB',
            'TenantBranch' => '2222',
            'numberdiv' => '2',
            'initNumber' => '20000',
            'editdiv' => '2',
            'lengs' => '7',
            'datediv' => '2',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 9,
            'TenantCode' => 'JTB',
            'TenantBranch' => '2222',
            'numberdiv' => '3',
            'initNumber' => '30000',
            'editdiv' => '3',
            'lengs' => '6',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 10,
            'TenantCode' => 'JTB',
            'TenantBranch' => '2222',
            'numberdiv' => '4',
            'initNumber' => '40000',
            'editdiv' => '4',
            'lengs' => '15',
            'datediv' => '1',
            'symbol' => 'JTB',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 11,
            'TenantCode' => 'JTB',
            'TenantBranch' => '2222',
            'numberdiv' => '5',
            'initNumber' => '50000',
            'editdiv' => '5',
            'lengs' => '7',
            'datediv' => '2',
            'symbol' => 'JTB',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 12,
            'TenantCode' => 'JTB',
            'TenantBranch' => '2222',
            'numberdiv' => '6',
            'initNumber' => '60000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '3',
        ]);

        DB::table('M_Numbering')->insert([
            'id' => 13,
            'TenantCode' => 'JTB',
            'TenantBranch' => '3333',
            'numberdiv' => '1',
            'initNumber' => '10000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 14,
            'TenantCode' => 'JTB',
            'TenantBranch' => '3333',
            'numberdiv' => '2',
            'initNumber' => '20000',
            'editdiv' => '2',
            'lengs' => '7',
            'datediv' => '2',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 15,
            'TenantCode' => 'JTB',
            'TenantBranch' => '3333',
            'numberdiv' => '3',
            'initNumber' => '30000',
            'editdiv' => '3',
            'lengs' => '6',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 16,
            'TenantCode' => 'JTB',
            'TenantBranch' => '3333',
            'numberdiv' => '4',
            'initNumber' => '40000',
            'editdiv' => '4',
            'lengs' => '15',
            'datediv' => '1',
            'symbol' => 'JTB',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 17,
            'TenantCode' => 'JTB',
            'TenantBranch' => '3333',
            'numberdiv' => '5',
            'initNumber' => '50000',
            'editdiv' => '5',
            'lengs' => '7',
            'datediv' => '2',
            'symbol' => 'JTB',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 18,
            'TenantCode' => 'JTB',
            'TenantBranch' => '3333',
            'numberdiv' => '6',
            'initNumber' => '60000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '3',
        ]);

        DB::table('M_Numbering')->insert([
            'id' => 19,
            'TenantCode' => 'JTB',
            'TenantBranch' => '4444',
            'numberdiv' => '1',
            'initNumber' => '10000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 20,
            'TenantCode' => 'JTB',
            'TenantBranch' => '4444',
            'numberdiv' => '2',
            'initNumber' => '20000',
            'editdiv' => '2',
            'lengs' => '7',
            'datediv' => '2',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 21,
            'TenantCode' => 'JTB',
            'TenantBranch' => '4444',
            'numberdiv' => '3',
            'initNumber' => '30000',
            'editdiv' => '3',
            'lengs' => '6',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 22,
            'TenantCode' => 'JTB',
            'TenantBranch' => '4444',
            'numberdiv' => '4',
            'initNumber' => '40000',
            'editdiv' => '4',
            'lengs' => '15',
            'datediv' => '1',
            'symbol' => 'JTB',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 23,
            'TenantCode' => 'JTB',
            'TenantBranch' => '4444',
            'numberdiv' => '5',
            'initNumber' => '50000',
            'editdiv' => '5',
            'lengs' => '7',
            'datediv' => '2',
            'symbol' => 'JTB',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 24,
            'TenantCode' => 'JTB',
            'TenantBranch' => '4444',
            'numberdiv' => '6',
            'initNumber' => '60000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '3',
        ]);

        DB::table('M_Numbering')->insert([
            'id' => 25,
            'TenantCode' => 'Ra',
            'TenantBranch' => '1111',
            'numberdiv' => '1',
            'initNumber' => '1000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '1',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 26,
            'TenantCode' => 'Ra',
            'TenantBranch' => '1111',
            'numberdiv' => '2',
            'initNumber' => '2000',
            'editdiv' => '2',
            'lengs' => '7',
            'datediv' => '2',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 27,
            'TenantCode' => 'Ra',
            'TenantBranch' => '1111',
            'numberdiv' => '3',
            'initNumber' => '3000',
            'editdiv' => '3',
            'lengs' => '6',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 28,
            'TenantCode' => 'Ra',
            'TenantBranch' => '1111',
            'numberdiv' => '4',
            'initNumber' => '4000',
            'editdiv' => '4',
            'lengs' => '15',
            'datediv' => '1',
            'symbol' => 'Ra',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 29,
            'TenantCode' => 'Ra',
            'TenantBranch' => '1111',
            'numberdiv' => '5',
            'initNumber' => '5000',
            'editdiv' => '5',
            'lengs' => '7',
            'datediv' => '1',
            'symbol' => 'Ra',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 30,
            'TenantCode' => 'Ra',
            'TenantBranch' => '2222',
            'numberdiv' => '1',
            'initNumber' => '1000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '1',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 31,
            'TenantCode' => 'Ra',
            'TenantBranch' => '2222',
            'numberdiv' => '2',
            'initNumber' => '2000',
            'editdiv' => '2',
            'lengs' => '7',
            'datediv' => '2',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 32,
            'TenantCode' => 'Ra',
            'TenantBranch' => '2222',
            'numberdiv' => '3',
            'initNumber' => '3000',
            'editdiv' => '3',
            'lengs' => '6',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 33,
            'TenantCode' => 'Ra',
            'TenantBranch' => '2222',
            'numberdiv' => '4',
            'initNumber' => '4000',
            'editdiv' => '4',
            'lengs' => '15',
            'datediv' => '3',
            'symbol' => 'Ra',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 34,
            'TenantCode' => 'Ra',
            'TenantBranch' => '2222',
            'numberdiv' => '5',
            'initNumber' => '5000',
            'editdiv' => '5',
            'lengs' => '7',
            'datediv' => '3',
            'symbol' => 'Ra',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 35,
            'TenantCode' => 'Ra',
            'TenantBranch' => '3333',
            'numberdiv' => '1',
            'initNumber' => '1000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 36,
            'TenantCode' => 'Ra',
            'TenantBranch' => '3333',
            'numberdiv' => '2',
            'initNumber' => '2000',
            'editdiv' => '2',
            'lengs' => '7',
            'datediv' => '2',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 37,
            'TenantCode' => 'Ra',
            'TenantBranch' => '3333',
            'numberdiv' => '3',
            'initNumber' => '3000',
            'editdiv' => '3',
            'lengs' => '6',
            'datediv' => '3',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 38,
            'TenantCode' => 'Ra',
            'TenantBranch' => '3333',
            'numberdiv' => '4',
            'initNumber' => '4000',
            'editdiv' => '4',
            'lengs' => '15',
            'datediv' => '1',
            'symbol' => 'Ra',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 39,
            'TenantCode' => 'Ra',
            'TenantBranch' => '3333',
            'numberdiv' => '5',
            'initNumber' => '5000',
            'editdiv' => '5',
            'lengs' => '7',
            'datediv' => '3',
            'symbol' => 'Ra',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 40,
            'TenantCode' => 'Ra',
            'TenantBranch' => '4444',
            'numberdiv' => '1',
            'initNumber' => '41000',
            'editdiv' => '1',
            'lengs' => '15',
            'datediv' => '1',
        ]);
        DB::table('M_Numbering')->insert([
            'id' => 41,
            'TenantCode' => 'Ra',
            'TenantBranch' => '4444',
            'numberdiv' => '2',
            'initNumber' => '2000',
            'editdiv' => '2',
            'lengs' => '7',
            'datediv' => '2',
        ]);
    }
}
