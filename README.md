# laravel-auth-sso

https://login.ctbuh.org/

### Install

> composer require ctbuh/laravel-auth-sso

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

Use from within your controller or as middleware:

```php
Route::middleware('auth:sso')->group(function () {

    Route::get('whoami', function(){
        $user = auth()->guard('sso')->user();
        return $user->getFirstName();
    });
    
});
```


### Route list

- /sso/login - Send person to login page.
- /sso/callback?access_token={token} -- If successful, person will be sent to this page.
- /sso/logout --- Revoke cookie & token itself.
