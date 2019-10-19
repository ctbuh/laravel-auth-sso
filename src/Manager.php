<?php

namespace ctbuh\Login;

final class Manager
{
    public function validateToken($token)
    {
        $data = file_get_contents("https://login.ctbuh.org/oauth/tokeninfo?access_token={$token}");
        $info = json_decode($data, true);

        return $info && !empty($info['id']);
    }

    public function revokeToken($token)
    {
        @file_get_contents("https://login.ctbuh.org/oauth/revoke?token={$token}");
        return true;
    }
}