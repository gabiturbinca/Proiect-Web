<?php

class NumericMinRule implements Rule {
    private int $min;

    public function __construct(int $min) {
        $this->min = $min;
    }
    public function passes(string $field, mixed $value, array $data): bool {
        if($value === null || $value === "") 
            return true;
        return ((int)$value) >= $this->min;
    }

    public function message(string $field): string {
        return "{$field} needs to be at least {$this->min}";
    }
}