<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Models\User;
use sbkl\SbklApi\Tests\LaravelTestCase;

class UserStoreTest extends LaravelTestCase
{
    /** @test */
    public function a_company_can_create_a_store_user()
    {
        // $this->withoutExceptionHandling();
        [
            'company' => $company,
            'admin_user' => $admin_user,
            'stores' => ['6004' => $store]
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'POST', 'api/admin/users', [
            'first_name' => $firstName = 'Hello',
            'last_name' => $lastName = 'World',
            'email' => $email = 'hello@world.com',
            'role' => $role = 'BOH',
            'plant' => $store->name,
            'lang' => $lang = 'en',
        ]);
        $this->assertDatabaseHas('users', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'plant_type' => get_class($store),
            'plant_id' => $store->id,
            'lang' => $lang,
        ]);
        $user = User::whereEmail($email)->first();
        $this->assertTrue($user->hasRole($role));
        $this->jsonAs($admin_user, 'POST', 'api/admin/users', [
            'first_name' => $firstName = 'Hello',
            'last_name' => $lastName = 'World',
            'email' => $email = 'hello@world.com',
            'role' => $role = 'HELLO',
            'plant' => $store->name,
            'lang' => $lang = 'en',
        ])->assertJsonValidationErrors(['email', 'role']);
    }

    /** @test */
    public function Admin_role_doesnt_require_a_plant()
    {
        [
            'company' => $company,
            'admin_user' => $admin_user,
            'stores' => ['6004' => $store]
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'POST', 'api/admin/users', [
            'first_name' => $firstName = 'Hello',
            'last_name' => $lastName = 'World',
            'email' => $email = 'hello@world.com',
            'role' => $role = 'Admin',
            'plant' => '',
            'lang' => $lang = 'en',
        ]);
        $this->assertDatabaseHas('users', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'plant_type' => null,
            'plant_id' => null,
            'lang' => $lang,
        ]);
    }
}
