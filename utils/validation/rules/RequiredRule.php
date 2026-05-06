<?php

class RequiredRule implements Rule {
    public function passes(string $field, mixed $value, array $parameters) : bool {
        return $value !== null && $value !== "" && $value !== [];
    }

    public function message(string $field) : string {
        return "{$field} is empty but required";
    }
}