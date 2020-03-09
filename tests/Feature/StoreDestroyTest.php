<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Models\Store;
use sbkl\SbklApi\Tests\LaravelTestCase;

class StoreDestroyTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_destroy_a_store()
    {
        $this->withoutExceptionHandling();
        [
            'company' => $company,
            'market' => $market,
            'stores' => ['6004' => $store],
            'admin_user' => $admin_user,
            'region' => $region,
        ] = EntityFactory::create();
        $newStore = factory(Store::class)->create();
        $this->jsonAs($admin_user, 'DELETE', "api/admin/stores/{$newStore->id}");
        $this->assertDatabaseMissing('stores', [
            'region_id' => $newStore->region_id,
            'name' => $newStore->name,
        ]);
        $this->jsonAs($admin_user, 'DELETE', "api/admin/stores/{$store->id}")->assertStatus(422);
    }
}
