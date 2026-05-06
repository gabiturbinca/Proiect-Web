<?php

class ConflictException extends RuntimeException {
    public function __construct(private array $errors, string $msg = "Resource conflict", ?Throwable $prev = null) {
        parent::__construct($msg,0, $prev);
    }
    public function getErrors(): array {
        return $this->errors;
    }
}