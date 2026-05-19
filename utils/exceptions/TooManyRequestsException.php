<?php


class TooManyRequestsException extends RuntimeException {
    public function __construct(private int $retryAfter = 300,string $msg = "Too many requests", ?Throwable $prev = null) {
        parent::__construct($msg, 0, $prev);
    }
    public function getRetry():int {
        return $this->retryAfter;
    }
}