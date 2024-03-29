<?php

namespace ctbuh\Login;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

class Controller
{
    /**
     * @var CookieJar
     */
    private $cookieJar;

    /**
     * @var Request
     */
    private $request;
    /**
     * @var Manager
     */
    private $manager;
    /**
     * @var Repository
     */
    private $config;

    public function __construct(Request $request, CookieJar $cookieJar, Manager $manager, Repository $config)
    {
        $this->request = $request;
        $this->cookieJar = $cookieJar;
        $this->manager = $manager;
        $this->config = $config;
    }

    public function login(Request $request)
    {
        return redirect()->to('https://login.ctbuh.org/oauth/authorize');
    }

    public function callback(Request $request)
    {
        $token = $request->get('access_token');
        $return_to = $request->get('return_to');

        if ($this->manager->validateToken($token)) {

            $minutes_year = 60 * 24 * 365;

            $default_domain = $this->config->get('session.domain');
            $domain = $this->config->get('sso.cookie.domain', $default_domain);

            // default: public function make($name, $value, $minutes = 0, $path = null, $domain = null, $secure = null, $httpOnly = true, $raw = false, $sameSite = null)
            $cookie = $this->cookieJar->make('sso_token', $token, $minutes_year, null, $domain);

            if (empty($return_to)) {
                $return_to = '/';
            }

            return redirect()->to($return_to)->withCookie($cookie);
        }

        return response()->make('Unauthorized', 400);
    }

    public function logout()
    {
        $sso_token = $this->request->cookies->get('sso_token');

        // in case not even logged in.
        if ($sso_token) {

            // revoke it forever
            $this->manager->revokeToken($sso_token);

            $forget_cookie = $this->cookieJar->forget('sso_token');
            return redirect()->back()->withCookie($forget_cookie);
        }

        return redirect()->back();
    }
}