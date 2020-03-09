<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class StoreStoreTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_create_a_store()
    {
        [
            'company' => $company,
            'market' => $market,
            'admin_user' => $admin_user,
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'POST', 'api/admin/stores', [
            'id' => $id = '1234',
            'market' => $market->name,
            'name' => $name = 'STORE TEST',
            'channel' => $channel = 'Outlet',
        ]);
        $this->assertDatabaseHas('stores', [
            'id' => $id,
            'market_id' => $market->id,
            'name' => $name,
            'channel' => $channel,
        ]);
        $this->jsonAs($admin_user, 'POST', 'api/admin/stores', [
            'id' => $id,
            'market' => $market->name,
            'name' => $name,
            'channel' => $channel,
        ])->assertJsonValidationErrors(['id', 'name']);
    }
}
