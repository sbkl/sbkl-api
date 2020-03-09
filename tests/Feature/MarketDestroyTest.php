<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Models\Market;
use sbkl\SbklApi\Tests\LaravelTestCase;

class MarketDestroyTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_destroy_a_market()
    {
        $this->withoutExceptionHandling();
        [
            'company' => $company,
            'market' => $market,
            'admin_user' => $admin_user,
            'region' => $region,
        ] = EntityFactory::create();
        $newMarket = factory(Market::class)->create();
        $this->jsonAs($admin_user, 'DELETE', "api/admin/markets/{$newMarket->id}");
        $this->assertDatabaseMissing('markets', [
            'region_id' => $newMarket->region_id,
            'name' => $newMarket->name,
        ]);
        $this->jsonAs($admin_user, 'DELETE', "api/admin/markets/{$market->id}")->assertStatus(422);
    }
}
