<?php


class CsrfException extends RuntimeException {
    public function __construct(string $msg = "Csrf exception", ?Throwable $prev = null) {
        parent::__construct($msg, 0, $prev);
    }
}