<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class MarketStoreTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_create_a_market()
    {
        [
            'company' => $company,
            'region' => $region,
            'admin_user' => $admin_user,
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'POST', 'api/admin/markets', [
            'name' => $name = 'MARKET TEST',
            'region' => $region->name,
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
