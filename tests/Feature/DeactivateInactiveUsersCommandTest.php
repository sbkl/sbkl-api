<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class DeactivateInactiveUsersCommandTest extends LaravelTestCase
{
    /** @test */
    public function it_deactivates_users_if_last_activity_at_is_null_and_created_more_than_three_months_ago()
    {
        [
            'store_users' => ['6004' => $user1, '6158' => $user2]
        ] = EntityFactory::create();
        $user2->update([
            'created_at' => now()->subMonths(3),
        ]);
        $this->artisan('sbkl:deactivate-users');
        $this->assertNull($user1->fresh()->last_activity_at);
        $this->assertNull($user2->fresh()->last_activity_at);
        $this->assertNull($user1->fresh()->deactivated_at);
        $this->assertNotNull($user2->fresh()->deactivated_at);
    }

    /** @test */
    public function it_deactivates_users_if_last_activity_at_is_more_than_three_months()
    {
        [
            'store_users' => ['6004' => $user1, '6158' => $user2]
        ] = EntityFactory::create();
        $user1->update([
            'created_at' => now()->subMonths(4),
            'last_activity_at' => now(),
        ]);
        $user2->update([
            'created_at' => now()->subMonths(4),
            'last_activity_at' => now()->subMonths(3),
        ]);
        $this->artisan('sbkl:deactivate-users');
        $this->assertNull($user1->fresh()->deactivated_at);
        $this->assertNotNull($user2->fresh()->deactivated_at);
    }
}
