<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class RegionUpdateTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_update_a_region()
    {
        [
            'company' => $company,
            'admin_user' => $admin_user,
            'region' => $region,
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'PATCH', "api/admin/regions/{$region->id}", [
            'name' => $name = 'REGION TEST',
        ]);
        $this->assertDatabaseMissing('regions', [
            'company_id' => $company->id,
            'name' => $region->name,
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
