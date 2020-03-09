<?php

use Illuminate\Database\Seeder;
use sbkl\SbklApi\Models\Market;
use sbkl\SbklApi\Models\Region;

class MarketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['Australia', 'Hong Kong', 'Macau', 'Malaysia', 'Singapore', 'Taiwan',  'Thailand'])->each(function ($market) {
            Market::create([
                'region_id' => Region::whereName('SOUTH ASIA PAC')->first()->id,
                'name' => $market,
            ]);
        });
    }
}
