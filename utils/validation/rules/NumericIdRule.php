<?php

class NumericIdRule implements Rule {

    public function passes(string $field, mixed $value, array $data): bool {
        if($value === null || $value === "") 
            return true;
        return ctype_digit((string) $value) && (int) $value > 0;
    }

    public function message(string $field): string {
        return "{$field} needs to be numeric int > 0";
    }
}