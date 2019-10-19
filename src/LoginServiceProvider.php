<?php

namespace ctbuh\Login;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var Router $router */
        $router = $this->app['router'];

        $router->middleware('web')->prefix('sso')->group(function (Router $router) {

            $router->get('/login')->uses('ctbuh\Login\Controller@login')->name('sso.login');
            $router->get('/callback')->uses('ctbuh\Login\Controller@callback')->name('sso.callback');
            $router->get('/logout')->uses('ctbuh\Login\Controller@logout')->name('sso.logout');
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sso.php', 'sso');

        Auth::extend('sso', function ($app, $name, array $config) {
            return new CookieGuard(resolve(UserProvider::class), $app['request']);
        });

        /*
        Auth::provider('sso', function ($app, array $config) {
            return new UserProvider();
        });
        */
    }
}
