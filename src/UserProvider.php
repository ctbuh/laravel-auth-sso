<?php

namespace ctbuh\Login;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider as ProviderContract;

class UserProvider implements ProviderContract
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $info = $this->getTokenInfo($identifier);
        return $info ? new User($info, $identifier) : null;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials['token'])) {
            return null;
        }

        $token = $credentials['token'];
        $info = $this->getTokenInfo($token);

        return $info ? new User($info, $token) : null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        return $user->getAuthPassword() == $credentials['token'];
    }

    protected function getTokenInfo($token)
    {
        try {

            $data = file_get_contents("https://login.ctbuh.org/oauth/tokeninfo?access_token={$token}");
            $info = json_decode($data, true);

            if ($info && isset($info['id'])) {
                return $info;
            }

        } catch (\Exception $exception) {
            // do nothing for now
        }

        return null;
    }

    // The methods below need to be defined because of the Authenticatable contract
    // but need no implementation for 'Auth::attempt' to work and can be implemented
    // if you need their functionality
    public function retrieveByToken($identifier, $token)
    {
    }

    public function updateRememberToken(UserContract $user, $token)
    {
    }
}