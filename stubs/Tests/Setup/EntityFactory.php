<?php

namespace sbkl\SbklApi\Tests\Setup;

use App\Company;
use App\Market;
use App\Region;
use Facades\Tests\Setup\StoreFactory;
use Facades\Tests\Setup\UserFactory;
use Spatie\Permission\Models\Role;

class EntityFactory
{
    public static function create()
    {
        collect(['Admin', 'OSL', 'FOH', 'BOH'])->each(function ($role) {
            factory(Role::class)->states($role)->create();
        });

        $company = factory(Company::class)->create();
        $region = factory(Region::class)->create([
            'company_id' => $company->id,
            'name' => 'SOUTH ASIA PAC',
        ]);
        $market = factory(Market::class)->create([
            'region_id' => $region->id,
            'name' => 'Hong Kong',
        ]);
        $stores = collect([['6004', 'Ocean Center'], ['6158', 'Canton Road'], ['6161', 'Pacific Place']])->map(function ($data, $index) use ($market) {
            [$id, $name] = $data;
            $store = StoreFactory::withId($id)->withName($name)->withMarketId($market->id)->create();

            return $store;
        })->reduce(function ($carry, $store) {
            $carry[$store->id] = $store;

            return $carry;
        }, []);

        $store_users = collect($stores)->map(function ($store) {
            $user = UserFactory::withPlant($store)->as('BOH')->create();

            return [$user, $store];
        })->reduce(function ($carry, $item) {
            [$user, $store] = $item;
            $carry[$store->id] = $user;

            return $carry;
        }, []);

        $admin_user = UserFactory::as('Admin')->create();

        return [
            'company' => $company,
            'region' => $region,
            'market' => $market,
            'stores' => $stores,
            'store_users' => $store_users,
            'admin_user' => $admin_user,
        ];
    }
}
