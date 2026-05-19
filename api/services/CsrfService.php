<?php


class CsrfService {
    public static function generateToken($length = 32) {
        return bin2hex(random_bytes($length));
    }

    public static function putCookie($token) {
        setcookie('csrf_token', $token, [
            'expires' => time() +3600,
            'path' => '/',
            'secure' => ($_ENV['APP_ENV'] ?? 'production') === 'production',
            'httponly' => false,
            'samesite' => 'Lax'
        ]);
    }
}