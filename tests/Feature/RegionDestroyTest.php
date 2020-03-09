<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Models\Region;
use sbkl\SbklApi\Tests\LaravelTestCase;

class RegionDestroyTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_destroy_a_region()
    {
        $this->withoutExceptionHandling();
        [
            'company' => $company,
            'admin_user' => $admin_user,
            'region' => $region,
        ] = EntityFactory::create();
        $newRegion = factory(Region::class)->create();
        $this->jsonAs($admin_user, 'DELETE', "api/admin/regions/{$newRegion->id}");
        $this->assertDatabaseMissing('regions', [
            'company_id' => $company->id,
            'name' => $newRegion->name,
        ]);
        $this->jsonAs($admin_user, 'DELETE', "api/admin/regions/{$region->id}")->assertStatus(422);
    }
}
