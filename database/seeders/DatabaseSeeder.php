<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersSeeder::class);
        // $this->call(TenantsSeeder::class);

        $this->call(M_NumberingsSeeder::class);

        $this->call(DivEditsSeeder::class);
        $this->call(DivDatesSeeder::class);
        $this->call(DivNumberSeeder::class);
        
        $this->call(DivisonSeeder::class);
        
        $this->call(M_TenantSeeder::class);
        $this->call(M_TenantBranchSeeder::class);

        // $this->call(CliantSeeder::class);
    }
}
