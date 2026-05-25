<?php

readonly class LoginRequestDTO {
    public const RULES = [
        'identifier' => ['required'],
        'password' => ['required'],
    ];
    public function __construct (
        //poate fi email sau username
        public string $identifier,
        public string $password,
    ) {}
}