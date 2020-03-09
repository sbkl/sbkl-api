<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['Admin', 'BOH', 'FOH', 'Office'])->each(function ($role) {
            Role::create(['name' => $role]);
        });
    }
}
