<?php

use App\Market;
use App\Region;
use Illuminate\Database\Seeder;

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
