<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class UserUpdateTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_update_a_region()
    {
        // $this->withoutExceptionHandling();
        [
            'company' => $company,
            'admin_user' => $admin_user,
            'region' => $region,
            'store_users' => ['6004' => $user],
            'stores' => ['6158' => $store]
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'PATCH', "api/admin/users/{$user->id}", [
            'first_name' => $firstName = 'Hello',
            'last_name' => $lastName = 'World',
            'email' => $email = 'hello@world.com',
            'role' => $role = 'BOH',
            'plant' => $store->name,
            'lang' => $lang = 'en',
        ]);
        $this->assertDatabaseMissing('users', [
            'company_id' => $company->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'lang' => $user->lang,
            'plant_type' => 'App\Store',
            'plant_id' => '6004',
        ]);
        $this->assertDatabaseHas('users', [
            'company_id' => $company->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'lang' => $lang,
            'plant_type' => get_class($store),
            'plant_id' => $store->id,
        ]);
        $this->assertEquals($role, $user->fresh()->role);
        $this->jsonAs($admin_user, 'POST', 'api/admin/users', [
            'first_name' => $firstName = 'Hello',
            'last_name' => $lastName = 'World',
            'email' => $email,
            'role' => $role = 'BOH',
            'plant' => $store->name,
            'lang' => $lang = 'en',
        ])->assertJsonValidationErrors(['email']);
    }
}
