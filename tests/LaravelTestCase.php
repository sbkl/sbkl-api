<?php

namespace sbkl\SbklApi\Tests;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use Orchestra\Testbench\TestCase;
use sbkl\SbklApi\Facades\Hello;
use sbkl\SbklApi\Models\User;
use sbkl\SbklApi\SbklComponentsServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class LaravelTestCase extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        include_once __DIR__ . '/../vendor/spatie/laravel-permission/database/migrations/create_permission_tables.php.stub';

        (new \CreatePermissionTables)->up();

        // $this->artisan('key:generate');

        $this->artisan('passport:keys');

        $this->withFactories(__DIR__ . '/../vendor/laravel/passport/database/factories');
        $this->withFactories(__DIR__ . '/../database/factories');

        // Passport::routes();
    }

    protected function getEnvironmentSetUp($app)
    {
        $config = $app->make(Repository::class);

        $config->set('auth.defaults.provider', 'users');

        $config->set('auth.providers.users.model', \sbkl\SbklApi\Models\User::class);

        $config->set('auth.guards.api', ['driver' => 'passport', 'provider' => 'users']);
    }

    public function jsonAs(User $user, $method, $endpoint, $data = [], $headers = [])
    {
        Passport::actingAs($user);

        return $this->json($method, $endpoint, $data, $headers);
    }

    protected function getPackageProviders($app)
    {
        return [
            SbklComponentsServiceProvider::class,
            PassportServiceProvider::class,
            // PermissionServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Hello' => Hello::class,
        ];
    }

    // protected function getEnvironmentSetUp($app)
    // {
    // include_once __DIR__ . '/../database/migrations/2001_01_01_000001_create_companies_table.php';
    // include_once __DIR__ . '/../database/migrations/2001_01_01_000002_create_regions_table.php';
    // include_once __DIR__ . '/../database/migrations/2001_01_01_000003_create_markets_table.php';
    // include_once __DIR__ . '/../database/migrations/2001_01_01_000004_create_stores_table.php';
    // include_once __DIR__ . '/../database/migrations/2001_01_01_000005_create_users_table.php';
    // include_once __DIR__ . '/../database/migrations/2001_01_01_000006_create_password_resets_table.php';
    // include_once __DIR__ . '/../vendor/spatie/laravel-permission/database/migrations/create_permission_tables.php.stub';
    // (new \CreateCompaniesTable)->up();
    // (new \CreateRegionsTable)->up();
    // (new \CreateMarketsTable)->up();
    // (new \CreateStoresTable)->up();
    // (new \CreateUsersTable)->up();
    // (new \CreatePasswordResetsTable)->up();
    // (new \CreatePermissionTables)->up();
    // }
}
