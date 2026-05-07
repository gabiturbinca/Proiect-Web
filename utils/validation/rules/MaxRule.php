<?php

class MaxRule implements Rule {
    private int $max;

    public function __construct(int $max) {
        $this->max = $max;
    }
    public function passes(string $field, mixed $value, array $data): bool {
        if($value === null || $value === "") 
            return true;
        return mb_strlen((string)$value) <= $this->max;
    }

    public function message(string $field): string {
        return "{$field} needs to be at most {$this->max} characters long";
    }
}