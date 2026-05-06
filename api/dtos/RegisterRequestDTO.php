<?php


readonly class RegisterRequestDTO {
    public function __construct(
        public int $username,
        public string $email,
        public string $password,
        public string $confirmed_password
    ) {}
}