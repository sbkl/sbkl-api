<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class StoreDeactivateTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_deactivate_a_store()
    {
        $this->withoutExceptionHandling();
        [
            'admin_user' => $admin_user,
            'stores' => ['6004' => $store],
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'PATCH', "api/admin/stores/{$store->id}/deactivate");
        $this->assertNotNull($store->fresh()->deactivated_at);
    }

    /** @test */
    public function a_company_can_activate_a_store()
    {
        // $this->withoutExceptionHandling();
        [
            'admin_user' => $admin_user,
            'stores' => ['6004' => $store],
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'PATCH', "api/admin/stores/{$store->id}/activate");
        $this->assertNull($store->fresh()->deactivated_at);
    }
}
