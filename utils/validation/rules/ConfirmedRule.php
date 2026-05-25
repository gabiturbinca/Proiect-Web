<?php

class ConfirmedRule implements Rule {
    public function passes(string $field, mixed $value, array $data): bool {
        if($value === null || $value === "") 
            return true;
        $confirmField = "{$field}_confirmation";
        return isset($data[$confirmField]) && $value === $data[$confirmField];
    }

    public function message(string $field): string {
        return "$field confirmation is not valid";
    }
}
