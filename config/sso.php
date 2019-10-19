<?php

return array(
    'homepage' => 'https://login.ctbuh.org/',
    'login_url' => 'https://login.ctbuh.org/oauth/authorize?service=' . env('APP_DOMAIN', 'ctbuh.org'),

    'cookie' => [
        'name' => 'sso_token',
        'max_age' => null
    ]
);
