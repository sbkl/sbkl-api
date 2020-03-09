<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class UserDeactivateTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_deactivate_a_user()
    {
        // $this->withoutExceptionHandling();
        [
            'admin_user' => $admin_user,
            'store_users' => ['6004' => $user]
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'PATCH', "api/admin/users/{$user->id}/deactivate");
        $this->assertNotNull($user->fresh()->deactivated_at);
    }

    /** @test */
    public function a_company_can_activate_a_user()
    {
        // $this->withoutExceptionHandling();
        [
            'admin_user' => $admin_user,
            'store_users' => ['6004' => $user]
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'PATCH', "api/admin/users/{$user->id}/activate");
        $this->assertNull($user->fresh()->deactivated_at);
    }
}
