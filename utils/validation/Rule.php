<?php


interface Rule {
    public function message(string $field): string;
    public function passes(string $field, mixed $value, array $data): bool;
}