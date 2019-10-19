<?php

namespace ctbuh\Login\Tests;

use ctbuh\Login\LoginServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected $token = "12175a37ebf1f3c469026be8c4ed0b7d";

    protected $credentials = array(
        'token' => '12175a37ebf1f3c469026be8c4ed0b7d'
    );

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'cwwpetqswqbvvellmaqdszsnraiiewfk');
        $app['config']->set('auth.guards.sso', ['driver' => 'sso']);
    }

    public function getPackageProviders($app)
    {
        return [LoginServiceProvider::class];
    }
}