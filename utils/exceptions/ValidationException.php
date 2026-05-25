<?php


class ValidationException extends RuntimeException {
    public function __construct(private array $errors, string $msg = "Validation failed", ?Throwable $prev = null) {
        parent::__construct($msg,0, $prev);
    }
    public function getErrors(): array {
        return $this->errors;
    }
}