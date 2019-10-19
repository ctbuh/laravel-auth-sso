# laravel-auth-sso

https://login.ctbuh.org/

### Usage

Add 'sso' guard to config/auth.php

```php
'sso' => [
    'driver' => 'sso',
    'provider' => null
]
```

Add this to config/app.php

> ctbuh\Login\LoginServiceProvider::class

Make sure SESSION_DOMAIN= is set to primary domain.

Reload all config

> php artisan config:cache

### Route list

- /sso/login - Send person to login page.
- /sso/callback?access_token={token} -- If successful, person will be sent to this page.
- /sso/logout --- Revoke cookie & token itself.
