<?php

namespace sbkl\SbklApi;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use sbkl\SbklApi\Console\Commands\DeactivateInactiveUsers;

class SbklComponentsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../vendor/laravel/passport/database/migrations');
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes([
                __DIR__ . '/../config/sbkl.php' => config_path('sbkl.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations/'),
            ], 'migrations');

            $this->publishes([
                __DIR__ . '/../stubs/Console/Commands' => app_path('Console/Commands'),
            ], 'commands');

            $this->publishes([
                __DIR__ . '/../stubs/database/factories' => database_path('factories/'),
            ], 'factories');

            $this->publishes([
                __DIR__ . '/../stubs/database/seeds' => database_path('seeds/'),
            ], 'seeders');

            $this->publishes([
                __DIR__ . '/../stubs/Http/Controllers/Api' => app_path('Http/Controllers/Api'),
            ], 'controllers');

            $this->publishes([
                __DIR__ . '/../stubs/Http/Middleware' => app_path('Http/Middleware'),
            ], 'middlewares');

            $this->publishes([
                __DIR__ . '/../stubs/Http/Resources' => app_path('Http/Resources'),
            ], 'resources');

            $this->publishes([
                __DIR__ . '/../stubs/Models' => app_path(),
            ], 'models');

            $this->publishes([
                __DIR__ . '/../stubs/Notifications' => app_path('Notifications'),
            ], 'notifications');

            $this->publishes([
                __DIR__ . '/../stubs/Tests/Setup' => base_path('tests/Setup'),
            ], 'test-setup');

            $this->publishes([
                __DIR__ . '/../stubs/Traits' => app_path('Traits'),
            ], 'traits');

            $this->commands([
                DeactivateInactiveUsers::class,
            ]);
        }

        Passport::routes();

        Sbkl::routes();
    }

    public function register()
    {
        if (env('APP_ENV') === 'testing') {
            $this->mergeConfigFrom(
                __DIR__ . '/../vendor/spatie/laravel-permission/config/permission.php',
                'permission'
            );
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../config/sbkl.php',
            'sbkl'
        );

        $this->app['router']->aliasMiddleware('activated', \sbkl\SbklApi\Http\Middleware\Activated::class);

        $this->app['router']->aliasMiddleware('role', \Spatie\Permission\Middlewares\RoleMiddleware::class);

        // Register facades example...
        $this->app->bind('hello', function () {
            return new HelloFactory();
        });
    }
}
