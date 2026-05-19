<?php


class CsrfMiddleware implements Middleware {

    public function __construct() {}
    public function handle(): void
    {
        $cookieToken = $_COOKIE['csrf_token'] ?? null;
        $headerToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

        if(!$cookieToken || !$headerToken || !hash_equals($cookieToken, $headerToken)) {
            throw new CsrfException("CSRF token mismatch");
        }
    }
}