<?php

namespace ctbuh\Login;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Support\Arrayable;

class User extends GenericUser implements UserContract, Arrayable
{
    private $token;

    /**
     * User constructor.
     * @param array $attributes
     * @param null $token
     */
    public function __construct($attributes, $token = null)
    {
        parent::__construct($attributes);
        $this->token = $token;
    }

    public function getEmail()
    {
        return $this->attributes['email'];
    }

    public function getFirstName()
    {
        return $this->attributes['first_name'];
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['id'];
    }

    public function getRememberToken()
    {
        return null;
    }

    public function getAuthPassword()
    {
        return $this->token;
    }

    public function getAccessToken()
    {
        return $this->token;
    }

    protected function getData($key = null)
    {
        if ($key) {
            return $this->attributes[$key];
        }

        return $this->attributes;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }
}

