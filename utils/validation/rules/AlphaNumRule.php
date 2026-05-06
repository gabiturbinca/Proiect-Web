<?php

class AlphaNumRule implements Rule {
    public function passes(string $field, mixed $value, array $data): bool {
        if($value === null || $value === "") 
            return true;
        return preg_match('/^[\p{L}\p{N}]+$/u',(string) $value) === 1;
    }

    public function message(string $field): string {
        return "$field needs to be alphanumeric";
    }
}