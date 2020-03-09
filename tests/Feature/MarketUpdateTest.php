<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class MarketUpdateTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_update_a_market()
    {
        [
            'company' => $company,
            'region' => $region,
            'market' => $market,
            'admin_user' => $admin_user,
            'region' => $region,
        ] = EntityFactory::create();
        $this->assertDatabasehas('markets', [
            'region_id' => $region->id,
            'name' => $market->name,
        ]);
        $this->jsonAs($admin_user, 'PATCH', "api/admin/markets/{$market->id}", [
            'region' => $region->name,
            'name' => $name = 'MARKET TEST',
        ]);
        $this->assertDatabaseMissing('markets', [
            'region_id' => $region->id,
            'name' => $market->name,
        ]);
        $this->assertDatabaseHas('markets', [
            'region_id' => $region->id,
            'name' => $name,
        ]);
        $this->jsonAs($admin_user, 'POST', 'api/admin/markets', [
            'region' => $region->name,
            'name' => $name = 'MARKET TEST',
        ])->assertJsonValidationErrors(['name']);
    }
}
