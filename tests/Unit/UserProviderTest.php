<?php

namespace ctbuh\Login\Tests\Unit;

use ctbuh\Login\Tests\TestCase;
use ctbuh\Login\User;
use ctbuh\Login\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Class UserProviderTest
 *
 * https://laravel.com/docs/5.7/authentication#the-user-provider-contract
 *
 * @package ctbuh\Login\Tests\Unit
 */
class UserProviderTest extends TestCase
{
    public function test_retrieve_by_id()
    {
        /** @var UserProvider $user_provider */
        $user_provider = resolve(UserProvider::class);

        /** @var Authenticatable $user */
        $user = $user_provider->retrieveById($this->token);
        $this->assertNotNull($user);
    }

    public function test_retrieve_by_credentials()
    {
        /** @var UserProvider $user_provider */
        $user_provider = resolve(UserProvider::class);

        $user = $user_provider->retrieveByCredentials($this->credentials);
        $this->assertNotNull($user);
    }

    public function test_validate_credentials()
    {
        /** @var UserProvider $user_provider */
        $user_provider = resolve(UserProvider::class);

        $user = new User([], $this->token);

        $user = $user_provider->validateCredentials($user, $this->credentials);
        $this->assertTrue($user);
    }
}