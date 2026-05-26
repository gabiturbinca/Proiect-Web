<?php

class ExternalServiceException extends RuntimeException {
    public function __construct(string $msg = "External service error", ?Throwable $prev = null) {
        parent::__construct($msg, 0, $prev);
    }
}