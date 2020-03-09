<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class UserLastActivityTest extends LaravelTestCase
{
    /** @test */
    public function register_the_date_of_last_activity_of_an_user()
    {
        $this->withoutExceptionHandling();
        [
            'company' => $company,
            'admin_user' => $admin_user,
            'store_users' => ['6004' => $user]
        ] = EntityFactory::create();
        $this->jsonAs($user, 'PATCH', 'api/admin/users/last-activity');
        $this->assertEquals(now(), $user->fresh()->last_activity_at);
    }
}
