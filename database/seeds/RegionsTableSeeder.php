<?php

use Illuminate\Database\Seeder;
use sbkl\SbklApi\Models\Company;
use sbkl\SbklApi\Models\Region;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['AMERICAS', 'CANADA', 'CHINA', 'EMEIA', 'JAPAN', 'KOREA', 'LATIN AMERICA', 'SOUTH ASIA PAC'])->each(function ($region) {
            Region::create([
                'name' => $region,
                'company_id' => Company::first()->id,
            ]);
        });
    }
}
