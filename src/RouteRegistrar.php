<?php

namespace sbkl\SbklApi;

use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->forUserAuth();
        $this->forPasswordReset();
        $this->forRegions();
        $this->forMarkets();
        $this->forStores();
        $this->forUsers();
        $this->forAdminPanel();
    }

    /**
     * Register the routes needed for user auth.
     *
     * @return void
     */
    public function forUserAuth()
    {
        $this->router->group(['middleware' => ['auth:api', 'activated']], function ($router) {
            $router->get('/user', [
                'uses' => 'Api\Auth\ProfileController@index',
                'as' => 'sbkl.auth.profile.index',
            ]);

            $router->patch('/user/lang', [
                'uses' => 'Api\Auth\LanguageController@update',
                'as' => 'sbkl.auth.lang.update',
            ]);

            $router->patch('/user/password', [
                'uses' => 'Api\Auth\ConfirmPasswordController@confirm',
                'as' => 'sbkl.auth.password.confirm',
            ]);

            $router->get('/user/logout', [
                'uses' => 'Api\Auth\LoginController@logout',
                'as' => 'sbkl.auth.logout',
            ]);

            $router->patch('/admin/users/last-activity', [
                'uses' => 'Api\Admin\UserLastActivityController@update',
                'as' => 'sbkl.auth.user.last-activity.update',
            ]);
        });
    }

    /**
     * Register the routes needed for password reset.
     *
     * @return void
     */
    public function forPasswordReset()
    {
        $this->router->group([], function ($router) {
            $router->post('/user/password/reset', [
                'uses' => 'Api\Auth\ResetPasswordController@requestPasswordReset',
                'as' => 'sbkl.passwordReset.requestPasswordReset',
            ]);

            $router->post('/user/password/reset/token', [
                'uses' => 'Api\Auth\ResetPasswordController@getUserForPasswordReset',
                'as' => 'sbkl.passwordReset.getUserForPasswordReset',
            ]);

            $router->patch('/user/{user}/password/reset', [
                'uses' => 'Api\Auth\ResetPasswordController@resetPassword',
                'as' => 'sbkl.passwordReset.resetPassword',
            ]);
        });
    }

    /**
     * Register the routes needed for regions.
     *
     * @return void
     */
    public function forRegions()
    {
        $this->router->group(['middleware' => ['auth:api', 'role:Admin']], function ($router) {
            $router->post('/admin/regions', [
                'uses' => 'Api\Admin\RegionController@store',
                'as' => 'sbkl.admin.region.store',
            ]);
            $router->patch('/admin/regions/{regionId}', [
                'uses' => 'Api\Admin\RegionController@update',
                'as' => 'sbkl.admin.region.update',
            ]);
            $router->delete('/admin/regions/{regionId}', [
                'uses' => 'Api\Admin\RegionController@destroy',
                'as' => 'sbkl.admin.region.destroy',
            ]);
        });
    }

    /**
     * Register the routes needed for markets.
     *
     * @return void
     */
    public function forMarkets()
    {
        $this->router->group(['middleware' => ['auth:api', 'role:Admin']], function ($router) {
            $router->post('/admin/markets', [
                'uses' => 'Api\Admin\MarketController@store',
                'as' => 'sbkl.admin.market.store',
            ]);
            $router->patch('/admin/markets/{marketId}', [
                'uses' => 'Api\Admin\MarketController@update',
                'as' => 'sbkl.admin.market.update',
            ]);
            $router->delete('/admin/markets/{marketId}', [
                'uses' => 'Api\Admin\MarketController@destroy',
                'as' => 'sbkl.admin.market.destroy',
            ]);
        });
    }

    /**
     * Register the routes needed for stores.
     *
     * @return void
     */
    public function forStores()
    {
        $this->router->group(['middleware' => ['auth:api', 'role:Admin']], function ($router) {
            $router->post('/admin/stores', [
                'uses' => 'Api\Admin\StoreController@store',
                'as' => 'sbkl.admin.store.store',
            ]);
            $router->patch('/admin/stores/{storeId}', [
                'uses' => 'Api\Admin\StoreController@update',
                'as' => 'sbkl.admin.store.update',
            ]);
            $router->delete('/admin/stores/{storeId}', [
                'uses' => 'Api\Admin\StoreController@destroy',
                'as' => 'sbkl.admin.store.destroy',
            ]);
            $router->patch('/admin/stores/{storeId}/activate', [
                'uses' => 'Api\Admin\StoreController@activate',
                'as' => 'sbkl.admin.store.activate',
            ]);
            $router->patch('/admin/stores/{storeId}/deactivate', [
                'uses' => 'Api\Admin\StoreController@deactivate',
                'as' => 'sbkl.admin.store.deactivate',
            ]);
        });
    }

    /**
     * Register the routes needed for users.
     *
     * @return void
     */
    public function forUsers()
    {
        $this->router->group(['middleware' => ['auth:api', 'role:Admin']], function ($router) {
            $router->post('/admin/users', [
                'uses' => 'Api\Admin\userController@store',
                'as' => 'sbkl.admin.user.store',
            ]);
            $router->patch('/admin/users/{userId}', [
                'uses' => 'Api\Admin\userController@update',
                'as' => 'sbkl.admin.user.update',
            ]);
            $router->patch('/admin/users/{userId}/activate', [
                'uses' => 'Api\Admin\userController@activate',
                'as' => 'sbkl.admin.user.activate',
            ]);
            $router->patch('/admin/users/{userId}/deactivate', [
                'uses' => 'Api\Admin\userController@deactivate',
                'as' => 'sbkl.admin.user.deactivate',
            ]);
        });
    }

    /**
     * Register the routes needed for users.
     *
     * @return void
     */
    public function forAdminPanel()
    {
        $this->router->group(['middleware' => ['auth:api', 'role:Admin']], function ($router) {
            $router->get('/admin/panel', [
                'uses' => 'Api\Admin\PanelController@index',
                'as' => 'sbkl.admin.panel',
            ]);
        });
    }
}
