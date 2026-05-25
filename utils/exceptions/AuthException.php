<?php


class AuthException extends RuntimeException {
    public function __construct(string $msg = "Invalid credentials", ?Throwable $prev = null) {
        parent::__construct($msg, 0, $prev);
    }
}