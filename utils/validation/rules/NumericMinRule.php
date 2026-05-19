<?php

class NumericMinRule implements Rule {
    private float $min;

    public function __construct(float $min) {
        $this->min = $min;
    }
    public function passes(string $field, mixed $value, array $data): bool {
        if($value === null || $value === "")
            return true;
        return is_numeric($value) && ((float) $value) >= $this->min;
    }

    public function message(string $field): string {
        return "{$field} needs to be at least {$this->min}";
    }
}