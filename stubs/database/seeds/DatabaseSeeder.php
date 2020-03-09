<?php

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
        $this->call(RolesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(MarketsTableSeeder::class);
        $this->call(StoresTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
