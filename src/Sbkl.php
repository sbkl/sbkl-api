<?php

namespace sbkl\SbklApi;

use Illuminate\Support\Facades\Route;

class Sbkl
{
    /**
     * Binds the Sbkl routes into the controller.
     *
     * @param  callable|null  $callback
     * @param  array  $options
     * @return void
     */
    public static function routes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };

        $defaultOptions = [
            'prefix' => 'api',
            'namespace' => env('APP_ENV') === 'testing' ? 'sbkl\SbklApi\Http\Controllers' : 'App\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }
}
