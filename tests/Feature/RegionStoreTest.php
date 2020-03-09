<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class RegionStoreTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_create_a_region()
    {
        [
            'company' => $company,
            'admin_user' => $admin_user,
        ] = EntityFactory::create();

        $this->jsonAs($admin_user, 'POST', 'api/admin/regions', [
            'name' => $name = 'REGION TEST',
        ]);

        $this->assertDatabaseHas('regions', [
            'company_id' => $company->id,
            'name' => $name,
        ]);

        $this->jsonAs($admin_user, 'POST', 'api/admin/regions', [
            'name' => $name = 'REGION TEST',
        ])->assertJsonValidationErrors(['name']);
    }
}
