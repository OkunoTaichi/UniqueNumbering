<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Authority;
use Database\Seeders\Person;
use Database\Seeders\RoomType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);

        $this->call(M_NumberingsSeeder::class);
        $this->call(M_DivisonSeeder::class);
        $this->call(M_TenantSeeder::class);
        $this->call(M_TenantBranchSeeder::class);

        $this->call(Authority\M_AuthoritySeeder::class);
        $this->call(Authority\M_AuthorityDetailSeeder::class);
        $this->call(Authority\M_ProgramSeeder::class);

        $this->call(Person\M_PersonSeeder::class);
        
        $this->call(RoomType\M_BuildingSeeder::class);
        $this->call(RoomType\M_RoomTypeSeeder::class);
        $this->call(RoomType\M_RoomSeeder::class);
 
    }
}
