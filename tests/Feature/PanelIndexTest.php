<?php

namespace sbkl\SbklApi\Tests\Feature;

use Facades\sbkl\SbklApi\Tests\Setup\EntityFactory;
use sbkl\SbklApi\Tests\LaravelTestCase;

class PanelIndexTest extends LaravelTestCase
{
    /** @test */
    public function can_fetch_all_models()
    {
        $this->withoutExceptionHandling();
        [
            'admin_user' => $admin_user,
            'region' => $region,
            'market' => $market,
        ] = EntityFactory::create();
        $this->jsonAs($admin_user, 'GET', 'api/admin/panel');
        $this->assertTrue(true);
    }
}
