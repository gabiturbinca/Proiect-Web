<?php

readonly class UserDTO {
    public function __construct(
        public int $id,
        public string $username,
        public string $email,
        public string $user_role
    ) {}
    
}