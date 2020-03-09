<?php

use App\Company;
use App\Region;
use Illuminate\Database\Seeder;

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
