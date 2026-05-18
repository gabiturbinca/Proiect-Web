<?php


class NumericMaxRule implements Rule {
    private float $max;

    public function __construct(float $max) {
        $this->max = $max;
    }
    public function passes(string $field, mixed $value, array $data): bool {
        if($value === null || $value === "")
            return true;
        return is_numeric($value) && ((float) $value) <= $this->max;
    }

    public function message(string $field): string {
        return "{$field} needs to be at most {$this->max}";
    }
}