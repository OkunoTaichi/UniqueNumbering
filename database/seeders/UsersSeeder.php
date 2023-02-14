<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'tenantCode' => 'ナバック',
            'tenantBranch' => '1111',
            'email' => 'test@test.com',
            'password'=> \Hash::make('password'),
        ]);
        // DB::table('users')->insert([
        //     'id' => 1,
        //     'name' => 'test',
        //     'email' => 'test@test.com',
        //     'password'=> \Hash::make('password'),
        // ]);
    }
}
