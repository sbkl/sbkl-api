<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Models\Store;
use sbkl\SbklApi\Tests\LaravelTestCase;

class StoreUpdateTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_update_a_store()
    {
        [
            'company' => $company,
            'region' => $region,
            'market' => $market,
            'stores' => [$initialId = '6004' => $store],
            'admin_user' => $admin_user,
            'region' => $region,
        ] = EntityFactory::create();
        $newStore = factory(Store::class)->create([
            'market_id' => $market->id,
        ]);
        $this->assertDatabasehas('stores', [
            'market_id' => $market->id,
            'name' => $store->name,
        ]);
        $this->assertDatabasehas('stores', [
            'market_id' => $market->id,
            'name' => $newStore->name,
        ]);
        $this->jsonAs($admin_user, 'PATCH', "api/admin/stores/{$store->id}", [
            'id' => $store->id,
            'market' => $market->name,
            'name' => $name = 'STORE TEST',
            'channel' => $store->channel,
        ]);
        $this->jsonAs($admin_user, 'PATCH', "api/admin/stores/{$newStore->id}", [
            'id' => $newStore->id,
            'market' => $market->name,
            'name' => $name2 = 'STORE TEST 2',
            'channel' => $newStore->channel,
        ]);
        $this->assertDatabaseMissing('stores', [
            'id' => $initialId,
            'market_id' => $market->id,
            'name' => $store->name,
            'channel' => $store->channel,
        ]);
        $this->assertDatabaseMissing('stores', [
            'id' => $newStore->id,
            'market_id' => $market->id,
            'name' => $newStore->name,
            'channel' => $newStore->channel,
        ]);
        $this->assertDatabaseHas('stores', [
            'id' => $initialId,
            'market_id' => $market->id,
            'name' => $name,
            'channel' => $store->channel,
        ]);
        $this->assertDatabaseHas('stores', [
            'id' => $newStore->id,
            'market_id' => $market->id,
            'name' => $name2,
            'channel' => $newStore->channel,
        ]);
        $this->jsonAs($admin_user, 'POST', 'api/admin/stores', [
            'id' => $id = '1234',
            'market' => $market->name,
            'name' => $name = 'STORE TEST',
            'channel' => $channel = 'Outlet',
        ])->assertJsonValidationErrors(['name']);
    }
}
