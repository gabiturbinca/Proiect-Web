<?php

class EmailRule implements Rule {
    public function passes(string $field, mixed $value, array $data): bool {
        if($value === null || $value === "") 
            return true;
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function message(string $field): string {
        return "$field needs to be a valid email address";
    }
}