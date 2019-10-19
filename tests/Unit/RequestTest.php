<?php

namespace ctbuh\Login\Tests\Unit;

use ctbuh\Login\Tests\TestCase;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

class RequestTest extends TestCase
{
    use MakesHttpRequests;

    public function test_callback()
    {
        $this->call('GET', 'sso/callback', ['access_token' => $this->token])->assertRedirect()->assertCookie('sso_token', $this->token);
    }

    public function test_invalid_callback()
    {
        $this->call('GET', 'sso/callback', ['access_token' => 'INVALID_TOKEN'])->assertStatus(400);
    }
}
