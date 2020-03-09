<?php

use Illuminate\Database\Seeder;
use sbkl\SbklApi\Models\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'Burberry',
        ]);
    }
}
