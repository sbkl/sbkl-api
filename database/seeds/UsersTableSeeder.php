<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use sbkl\SbklApi\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'company_id' => 1,
            'first_name' => 'Sebastien',
            'last_name' => 'Koziel',
            'email' => 'sebastien.koziel@burberry.com',
            'password' => Hash::make('secret'),
            'lang' => 'en',
        ]);
        $admin->assignRole('Admin');
    }
}
