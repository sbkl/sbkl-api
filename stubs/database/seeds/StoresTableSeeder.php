<?php

use App\Market;
use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => 'Macau',
                'stores' => [
                    [
                        'id' => '6200',
                        'name' => 'One Central',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6203',
                        'name' => 'Galaxy',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6204',
                        'name' => 'Wynn Palace Cotai',
                        'channel' => 'Mainline',
                    ],
                ],
            ],
            [
                'name' => 'Hong Kong',
                'stores' => [
                    [
                        'id' => '6004',
                        'name' => 'Ocean Centre',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6158',
                        'name' => 'Canton Road',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6194',
                        'name' => 'HKIA',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6161',
                        'name' => 'Pacific Place',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6192',
                        'name' => 'Sogo CWB',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6162',
                        'name' => 'Russel Street',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6181',
                        'name' => 'Elements',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6191',
                        'name' => 'Alexandra House',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6172',
                        'name' => 'Ocean Terminal CHW',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6190',
                        'name' => 'Sogo CWB CHW',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6153',
                        'name' => 'Lee Gardens Two CHW',
                        'channel' => 'Mainline',
                    ],
                    [
                        'id' => '6193',
                        'name' => 'City Gate',
                        'channel' => 'Outlet',
                    ],
                ],
            ],
        ])->each(function ($market) {
            $marketModel = Market::whereName($market['name'])->first();
            collect($market['stores'])->each(function ($store) use ($marketModel) {
                $marketModel->stores()->create([
                    'id' => $store['id'],
                    'name' => $store['name'],
                    'channel' => $store['channel'],
                ]);
            });
        });
    }
}
